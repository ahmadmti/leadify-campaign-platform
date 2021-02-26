<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Reply;
use App\Http\Requests\Admin\Appointment\StoreRequest;
use App\Http\Requests\Admin\Appointment\UpdateRequest;
use App\Models\Appointment;
use App\Models\Campaign;
use App\Models\Lead;
use App\Models\User;
use App\Models\SalesMember;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Helper;
use App\Notifications\SendMeetingLink;
use Illuminate\Support\Facades\Notification;

class AppointmentCalendarController extends AdminBaseController
{
     /**
	 * UserController constructor.
	 */

    public function __construct()
    {
        parent::__construct();

        $this->pageTitle = trans('menu.appointmentCalendar');
        $this->pageIcon = 'fa fa-calendar-alt';
        $this->appointmentMenuActive = 'active';
        $this->bootstrapModalRight = false;
    }
    public function bookAppointmentLink()
    {
        return view('admin.public-appointment.index');
    }
    
    public function index(Request $request)
    {
        $this->appointmentCalendarActive = 'active';
        $this->allSalesMembers = SalesMember::all();
        
        return view('admin.appointment-calendar.index', $this->data);
    }

    public function getAppointments(Request $request)
    {
        $campaignId = $request->campaign_id;
        $salesmanId = $request->salesman_id;
        $startDate = $request->start;
        $endDate = $request->end;
        $userActiveCampaigns = $this->user->activeCampaigns()->pluck('id')->toArray();

        // current user is not member of  selected campaign
        if($campaignId != '' && !in_array($campaignId, $userActiveCampaigns))
        {
            return [];
        }

        $appointments = Appointment::select('sales_members.first_name', 'sales_members.last_name', 'appointments.appointment_time', 'appointments.sales_member_id', 'appointments.id', 'appointments.lead_id')
                                    ->join('leads', 'leads.id', '=', 'appointments.lead_id')
                                    ->join('sales_members', 'sales_members.id', '=', 'appointments.sales_member_id')
                                    ->whereBetween(DB::raw('DATE(appointments.appointment_time)'), [$startDate, $endDate]);

        // Only Admin can see all booked appointments
        if(!$this->user->hasRole('admin'))
        {
            $appointments = $appointments->where('created_by', $this->user->id);
        }

        if($salesmanId != '')
        {
            $appointments = $appointments->where('appointments.sales_member_id', $salesmanId);
        }

        if($campaignId == '')
        {
            $appointments = $appointments->whereIn('leads.campaign_id', $userActiveCampaigns);
        } else {
            $appointments = $appointments->where('leads.campaign_id', $campaignId);
        }

        $appointments = $appointments->orderBy('appointments.appointment_time', 'asc')->get();

        $appointmentData = [];

        foreach ($appointments as $appointment)
        {
            $appointmentData[] = [
                'title' => $appointment->first_name . ' ' . $appointment->last_name,
                'start' => $appointment->appointment_time,
                'backgroundColor'=> "#007bff",
                'borderColor'=> "#007bff",
                'textColor'=> '#fff',
                'lead_id' => $appointment->lead_id,
                'appointment_id' => $appointment->id
            ];
        }

        return $appointmentData;
    }

    public function edit($id)
    {
        $this->icon = 'edit';
        $this->appointment = Appointment::findOrFail($id);
        $this->lead = $this->appointment->lead;

        // Check current logged in user is member of appointment campaign
        $userActiveCampaigns = $this->user->activeCampaigns()->pluck('id')->toArray();
        if(!in_array($this->appointment->lead->campaign_id, $userActiveCampaigns))
        {
            return response()->view($this->forbiddenErrorView);
        }

        $this->allSalesMembers = SalesMember::all();
	
	// return $this->data;
        return view('admin.appointment-calendar.edit', $this->data);
    }


 
   
    public function update(UpdateRequest $request,$id)
    {
      
        // return $request->all();
        try {
            $user = Auth::user();
            $timezone = $user->timezone;
            $appointment         = Appointment::findOrFail($id);

        // Check current logged in user is member of appointment campaign
        $userActiveCampaigns = $this->user->activeCampaigns()->pluck('id')->toArray();
        if(!in_array($appointment->lead->campaign_id, $userActiveCampaigns))
        {
            $errorMessage = Reply::error('messages.notAllowed');

            return response()->json($errorMessage);
        }

        \DB::beginTransaction();
        $time = Carbon::createFromFormat('m-d-Y H:i', $request->appointment_time)->format('Y-m-d H:i:s');
        
        if ($appointment->appointment_time == $time) 
        {
        //   return "if"; 
          $appointment->appointment_time =  $time;
        }
        else
        {
            if ($timezone == "Indian/Mauritius") {
                $appointment->appointment_time =  Carbon::parse($time)->addMinutes(180);
            }
            else {
                $appointment->appointment_time =  $time;
            }
        }
        if ($request->meeting) {
            $appointment->meeting_link	 = $this->CryptoJSAesEncrypt('usman',$appointment->appointment_time);
            
            $this->meetingLink($appointment->appointment_time);
            $saleMember = SalesMember::where('id',$request->sales_member_id)->first();
            $code = json_decode($appointment->meeting_link,true);
            $url = url("/admin/meeting").'?st='.$code['salt'].'&iv='.$code['iv'].'&clp='.$code['ciphertext']; 

           Notification::route('mail', $saleMember->email)->notify(new SendMeetingLink('Appointment Meeting Link',$url));
      
        }
        $appointment->sales_member_id = $request->sales_member_id;
        $appointment->save();
            
        \DB::commit();

        $data = [
            'html' => '<input type="hidden" id="delete_appointment_id" name="delete_appointment_id" value="'.$appointment->id.'"><a href="javascript:;" onclick="appointmentChanged()">'.trans('app.view').'</a>'
        ];

        return Reply::successWithData($data);
        } catch (\Exception $th ) {
            return $th;
           }
      

    }

    public function destroy($id)
    {
        $appointment         = Appointment::findOrFail($id);

        // Check current logged in user is member of appointment campaign
        $userActiveCampaigns = $this->user->activeCampaigns()->pluck('id')->toArray();
        if(!in_array($appointment->lead->campaign_id, $userActiveCampaigns))
        {
            $errorMessage = Reply::error('messages.notAllowed');

            return response()->json($errorMessage);
        }

        $appointment->delete();

        return Reply::success('messages.deleteSuccess');
    }

    public function addEditByLead($leadId)
    {
        $this->icon = 'edit';
        $lead = Lead::whereRaw('md5(id) = ?', $leadId)->first();
        $this->appointment = $lead->appointment ? $lead->appointment : new Appointment();
        $this->lead = $lead;
        // Check current logged in user is member of appointment campaign
        $userActiveCampaigns = $this->user->activeCampaigns()->pluck('id')->toArray();
        if(!in_array($lead->campaign_id, $userActiveCampaigns))
        {
            return response()->view($this->forbiddenErrorView);
        }

        $this->allSalesMembers = User::all();

        return view('admin.appointment-calendar.add-edit', $this->data);
    }
    
   
    public function getBookedAppointments()
    {
      $this->bookedAppointments = Appointment::select('sales_members.first_name', 'sales_members.last_name', 'campaigns.id as campaign_id', 'campaigns.name as campaign_name', 'appointments.appointment_time', 'appointments.sales_member_id', 'appointments.id', 'appointments.lead_id')
     ->join('leads', 'leads.id', '=', 'appointments.lead_id')
     ->join('campaigns', 'campaigns.id', '=', 'leads.campaign_id')
     ->join('sales_members', 'sales_members.id', '=', 'appointments.sales_member_id')
     // ->where('appointments.created_by', $this->user->id)
     ->where('campaigns.status', '!=', 'completed')
     ->latest('appointments.created_at')
     ->take(5)
     ->get();
     return view('admin.booked-appointments.index', $this->data);
    }
 
    private function sortTime($SalesMember)
    {
    
        $date_arr=$SalesMember;
        if ($date_arr) {
    
         usort($date_arr, function($a, $b) {
             if($b['schedule']){
                 $dateTimestamp1 = strtotime($a['schedule']['start_time']);
                 $dateTimestamp2 = strtotime($b['schedule']['start_time']);
     
                 return $dateTimestamp1 < $dateTimestamp2 ? -1: 1;
             }else{
                 return 1;
             }
         });
          $min =  Carbon::parse($date_arr[0]['schedule']['start_time'])->format('H:i:s');
         $max =  Carbon::parse($date_arr[count($date_arr)-1]['schedule']['end_time'])->format('H:i:s');
         
      

          $selectedTime  = Carbon::parse($min)->format('H:i'); // 2017-04-01 00:00:00
   
         $allTimes = [];
         array_push($allTimes, $selectedTime); 
        
         for ($i = 0; $i <= $max; $i++){ 
             
             $selectedTime = date('h:i',strtotime("+15 minutes", strtotime($selectedTime)));
             array_push($allTimes, $selectedTime); 
         }
        return   $allTimes;

        //  $checkTimeAvailable = Appointment::select('id','appointment_time')->get();

       

        //  foreach($allTimes as $totalTime)
        //  {
            
        //     foreach($checkTimeAvailable as $timeNotAvailable)
        //     {    
        //         $calculatetime =  Carbon::createFromFormat('Y-m-d H:i:s',$timeNotAvailable['appointment_time'])->format('g:i A');
        //         $time = Carbon::parse($calculatetime)->subMinutes(180);
        //         return Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('g:i A');
        //         if ($time == $totalTime) {
        //           return $totalTime;
        //         }
        //         else {
        //             return "else";
        //         }
               
        //     }
        //  }

        }
     
    }
    public function checkAvailableTime(Request $request)
     {
        // return  $request->all();
        try {
            
         $date = Carbon::createFromFormat('m-d-Y',$request->date)->format('Y-m-d');
         $day = Carbon::createFromFormat('m-d-Y',$request->date)->format('l');
         
         if ($request->agent) 
         {
           
            $SalesMember = User::with(['schedule'=>function($query) use($day){
                $query->where('day',$day)->where('status','1');
               },
               'staffMembers'=>function($q) use($request){
                $q->where('campaign_id',$request->campaign_id);
               }])->where('sales_member','0')->get()->toArray();
         }
         else 
         {
            $SalesMember = SalesMember::with(['schedule'=>function($query) use($day){
                $query->where('day',$day)->where('status','1');
               },
               'staffMembers'=>function($q) use($request){
                $q->where('campaign_id',$request->campaign_id);
               }])->get()->toArray();
         }
     
         
       $users=[];
        foreach ($SalesMember as  $user) {
            if ($user['schedule'] != null) {
               
                $users = [...$users,$user];
            } 
        }
        // return $users;
        return $this->sortTime($users);
        
 
        } 
        catch (\Exception $th ) {
         return $th;
        }
         
 
     }
     public function checkAppointments(Request $request)
     {
      
         try {
             $day = Carbon::createFromFormat('m-d-Y',$request->date)->format('l');
             
             $date = Carbon::createFromFormat('m-d-Y',$request->date)->format('Y-m-d');
             $user = Auth::user();
             $timezone = $user->timezone;
             if ($timezone == "Indian/Mauritius") {
              $calculatetime =  Carbon::createFromFormat('H:i',$request->time)->addMinutes(180);
             }
             else {
                $calculatetime =  Carbon::createFromFormat('H:i',$request->time);
             }
            $time = Carbon::parse($calculatetime)->format('H:i:s');
             
            $checkDateTime =  $date.' '.$time;
            
         
            $SalesMember = SalesMember::with(['schedule'=>function($query) use($day){
                $query->where('day',$day)->where('status','1');
               },
               'staffMembers'=>function($q) use($request){
                $q->where('campaign_id',$request->campaign_id);
               }])->get()->toArray();
            
            $salesMan=[];
               foreach ($SalesMember as  $sales) {
                   if ($sales['schedule'] != null && $sales['staff_members'] != null ) {
                      
                       $salesMan = [...$salesMan,$sales];
                   } 
               }
               
             $appointment = Appointment::where('appointment_time',$checkDateTime)->get();
             // return $appointment;
             $users=[];
             if($appointment->count()>0){
             
                     foreach($salesMan as $user){
                     $exis=true;
                         foreach($appointment as $check){
                             if((int)$user['id'] == (int) $check->sales_member_id){
                                 $exis = false;
                                 break;
                             }
                         }
                         if($exis){
                             $users = [...$users,$user];
                         }
                     
                     }
               }else{
                
                 $users = $salesMan;
               }
             return $users;
 
 
         }
         catch (\Exception $th ) {
             return $th;
            }
           
       
     }
    
    public function store(StoreRequest $request)
    {
        // return $request->all();
       \DB::beginTransaction();

       $user = Auth::user();
       $timezone = $user->timezone;
     
      
       try {
            $appointment         = new Appointment();
            $appointment->lead_id = $request->lead_id;
            if ($timezone == "Indian/Mauritius") {
            $appointment->appointment_time = Carbon::createFromFormat('m-d-Y H:i', $request->appointment_time)->addMinutes(180);
            }
            else {
                $appointment->appointment_time = Carbon::createFromFormat('m-d-Y H:i', $request->appointment_time);
            }
            $appointment->sales_member_id = $request->sales_member_id;
            $appointment->created_by = $this->user->id;
            if ($request->meeting) {
            
            $appointment->meeting_link	 = $this->CryptoJSAesEncrypt('usman',$appointment->appointment_time);
            $saleMember = SalesMember::where('id',$request->sales_member_id)->first();
     
            $code = json_decode($appointment->meeting_link,true);
             $url = url("/admin/meeting").'?st='.$code['salt'].'&iv='.$code['iv'].'&clp='.$code['ciphertext']; 

            Notification::route('mail', $saleMember->email)->notify(new SendMeetingLink('Appointment Meeting Link',$url));
       
            
          
            $this->meetingLink($appointment->appointment_time);
            
            }
            $appointment->save();
            
          
            $lead = Lead::find($request->lead_id);
            $lead->appointment_booked = true;
            $lead->save();
    
            \DB::commit();
    
            $data = [
                'html' => '<input type="hidden" id="delete_appointment_id" name="delete_appointment_id" value="'.$appointment->id.'"><a href="javascript:;" onclick="appointmentChanged()">'.trans('app.view').'</a>'
            ];
    
            return Reply::successWithData($data);     //code...
        } catch (\Exception $th ) {
         return $th;
        }
       

    }
    private function meetingLink($time){
        return $this->CryptoJSAesEncrypt( 'usman',$time);
       

    }
    private function CryptoJSAesEncrypt($passphrase, $plain_text){

        $salt = openssl_random_pseudo_bytes(40);
        $iv = openssl_random_pseudo_bytes(16);
        //on PHP7 can use random_bytes() istead openssl_random_pseudo_bytes()
        //or PHP5x see : https://github.com/paragonie/random_compat
    
        $iterations = 99;  
        $key = hash_pbkdf2("sha512", $passphrase, $salt, $iterations, 64);
    
        $encrypted_data = openssl_encrypt($plain_text, 'aes-256-cbc', hex2bin($key), OPENSSL_RAW_DATA, $iv);
    
        $data = array("ciphertext" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "salt" => bin2hex($salt));
        // return $data;
        return json_encode($data);
    }
    
    // $string_json_fromPHP = CryptoJSAesEncrypt("your passphrase", "your plain text");
    
 
}