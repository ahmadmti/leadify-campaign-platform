<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Role;
use Auth;
use Carbon\Carbon;
use App\Classes\Reply;
use App\Models\SalesMember;

class ScheduleSettingController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = trans('module_settings.setSchedule');
        $this->pageIcon = 'fa fa-calendar-alt';
        $this->ScheduleActive = 'active';
        $this->bootstrapModalRight = false;
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->ScheduleActive ="active";
        $this->icon = 'edit';
    
        $Schedule = Schedule::where('user_id',Auth::id())->get();
        // return $this->data;
        return view('admin.settings.schedule.index',compact('Schedule'),$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //  return $sunday_start_time =  Carbon::createFromFormat('H:i',$request->sunday_start_time)->addMinutes(180);
        // return $request->all();
        try {
      
            $user = Auth::user();
            $timezone = $user->timezone;
            $role_id = $user->roles->first()->id;
        
            $role = Role::where('name',strtolower('Agent'))->first();
            $agentRoleID = $role->id; 

            $role = Role::where('name',strtolower('Sales'))->first();
            $saleRoleID = $role->id; 
            

        if ($request->day_sunday) {

        $schedule =new Schedule;
        $userID = Auth::id();
        $schedule->user_id =  $userID;
        
          $schedule->day  = 'Sunday';
          if ($timezone == "Indian/Mauritius") {
            $sunday_start_time =  Carbon::createFromFormat('H:i',$request->sunday_start_time)->addMinutes(180);
            $schedule->start_time  = $sunday_start_time;
            
            $sunday_end_time =  Carbon::createFromFormat('H:i',$request->sunday_end_time)->addMinutes(180);
            $schedule->end_time  = $sunday_end_time;
          }
          
          else {
            $schedule->start_time  = $request->sunday_start_time;
            $schedule->end_time  = $request->sunday_end_time;
          }
         
          $schedule->status  = 'Available';
          if ($role_id == $agentRoleID) 
          {
            $schedule->role_id  =  $agentRoleID;
          }
          else 
          {
            $schedule->role_id  =  $saleRoleID;
          }
          $schedule->save();
        }
        else {
            $schedule =new Schedule;
            $userID = Auth::id();
            $schedule->user_id =  $userID;
            
            $schedule->day  = 'Sunday';
            $schedule->start_time  = "00:00:00";
            $schedule->end_time  = "00:00:00";
            $schedule->status  = 'Not Available';
            if ($role_id == $agentRoleID) 
            {
              $schedule->role_id  =  $agentRoleID;
            }
            else 
            {
              $schedule->role_id  =  $saleRoleID;
            }
            $schedule->save();
        }
        
        if ($request->day_monday) {
            $schedule =new Schedule;
            $userID = Auth::id();
            $schedule->user_id =  $userID;

            $schedule->day  = 'Monday';
            if ($timezone == "Indian/Mauritius") {
              $start_time =  Carbon::createFromFormat('H:i',$request->monday_start_time)->addMinutes(180);
              $schedule->start_time  = $start_time;
              
              $end_time =  Carbon::createFromFormat('H:i',$request->monday_end_time)->addMinutes(180);
              $schedule->end_time  = $end_time;
            }
            
            else {
              $schedule->start_time  = $request->monday_start_time;
              $schedule->end_time  = $request->monday_end_time;
            }
          
            $schedule->status  = 'Available';
            if ($role_id == $agentRoleID) 
            {
              $schedule->role_id  =  $agentRoleID;
            }
            else 
            {
              $schedule->role_id  =  $saleRoleID;
            }
            $schedule->save();

        }
        else {
            $schedule =new Schedule;
            $userID = Auth::id();
            $schedule->user_id =  $userID;
            
            $schedule->day  = 'Monday';
            $schedule->start_time  = "00:00:00";
            $schedule->end_time  = "00:00:00";
            $schedule->status  = 'Not Available';
            if ($role_id == $agentRoleID) 
            {
              $schedule->role_id  =  $agentRoleID;
            }
            else 
            {
              $schedule->role_id  =  $saleRoleID;
            }
            $schedule->save();
        }
        
        if ($request->day_tuesday != null) {
            $schedule =new Schedule;
            $userID = Auth::id();
            $schedule->user_id =  $userID;

            $schedule->day  = 'Tuesday';
            if ($timezone == "Indian/Mauritius") {
              $start_time =  Carbon::createFromFormat('H:i',$request->tuesday_start_time)->addMinutes(180);
              $schedule->start_time  = $start_time;
              
              $end_time =  Carbon::createFromFormat('H:i',$request->tuesday_end_time)->addMinutes(180);
              $schedule->end_time  = $end_time;
            }
            
            else {
              $schedule->start_time  = $request->tuesday_start_time;
              $schedule->end_time  = $request->tuesday_end_time;
            }
          
            $schedule->status  = 'Available';
            if ($role_id == $agentRoleID) 
            {
              $schedule->role_id  =  $agentRoleID;
            }
            else 
            {
              $schedule->role_id  =  $saleRoleID;
            }
            $schedule->save();
        }

        else {
            $schedule =new Schedule;
            $userID = Auth::id();
            $schedule->user_id =  $userID;
            
            $schedule->day  = 'Tuesday';
            $schedule->start_time  = "00:00:00";
            $schedule->end_time  = "00:00:00";
            $schedule->status  = 'Not Available';
            if ($role_id == $agentRoleID) 
            {
              $schedule->role_id  =  $agentRoleID;
            }
            else 
            {
              $schedule->role_id  =  $saleRoleID;
            }
            $schedule->save();
        }
     
        if ($request->day_wednesday != null) {
            $schedule =new Schedule;
            $userID = Auth::id();
            $schedule->user_id =  $userID;

            $schedule->day  = 'Wednesday';
            if ($timezone == "Indian/Mauritius") {
              $start_time =  Carbon::createFromFormat('H:i',$request->wednesday_start_time)->addMinutes(180);
              $schedule->start_time  = $start_time;
              
              $end_time =  Carbon::createFromFormat('H:i',$request->wednesday_end_time)->addMinutes(180);
              $schedule->end_time  = $end_time;
            }
            
            else {
              $schedule->start_time  = $request->wednesday_start_time;
              $schedule->end_time  = $request->wednesday_end_time;
            }
          
           
            $schedule->status  = 'Available';
            if ($role_id == $agentRoleID) 
            {
              $schedule->role_id  =  $agentRoleID;
            }
            else 
            {
              $schedule->role_id  =  $saleRoleID;
            }
            $schedule->save();
        }

        else {
            $schedule =new Schedule;
            $userID = Auth::id();
            $schedule->user_id =  $userID;
            
            $schedule->day  = 'Wednesday';
            $schedule->start_time  = "00:00:00";
            $schedule->end_time  = "00:00:00";
            $schedule->status  = 'Not Available';
            if ($role_id == $agentRoleID) 
            {
              $schedule->role_id  =  $agentRoleID;
            }
            else 
            {
              $schedule->role_id  =  $saleRoleID;
            }
            $schedule->save();
        }
        
        
        if ($request->day_thursday != null) {
            $schedule =new Schedule;
            $userID = Auth::id();
            $schedule->user_id =  $userID;

            $schedule->day  = 'Thursday';
            if ($timezone == "Indian/Mauritius") {
              $start_time =  Carbon::createFromFormat('H:i',$request->thursday_start_time)->addMinutes(180);
              $schedule->start_time  = $start_time;
              
              $end_time =  Carbon::createFromFormat('H:i',$request->thursday_end_time)->addMinutes(180);
              $schedule->end_time  = $end_time;
            }
            
            else {
              $schedule->start_time  = $request->thursday_start_time;
              $schedule->end_time  = $request->thursday_end_time;
            }
          
            $schedule->status  = 'Available';
            if ($role_id == $agentRoleID) 
            {
              $schedule->role_id  =  $agentRoleID;
            }
            else 
            {
              $schedule->role_id  =  $saleRoleID;
            }
            $schedule->save();
        }

        else {
            $schedule =new Schedule;
            $userID = Auth::id();
            $schedule->user_id =  $userID;
            
            $schedule->day  = 'Thursday';
            $schedule->start_time  = "00:00:00";
            $schedule->end_time  = "00:00:00";
            $schedule->status  = 'Not Available';
            if ($role_id == $agentRoleID) 
            {
              $schedule->role_id  =  $agentRoleID;
            }
            else 
            {
              $schedule->role_id  =  $saleRoleID;
            }
            $schedule->save();
        }
        
        
        if ($request->day_friday != null) {
            $schedule =new Schedule;
            $userID = Auth::id();
            $schedule->user_id =  $userID;

            $schedule->day  = 'Friday';
            if ($timezone == "Indian/Mauritius") {
              $start_time =  Carbon::createFromFormat('H:i',$request->friday_start_time)->addMinutes(180);
              $schedule->start_time  = $start_time;
              
              $end_time =  Carbon::createFromFormat('H:i',$request->friday_end_time)->addMinutes(180);
              $schedule->end_time  = $end_time;
            }
            
            else {
              $schedule->start_time  = $request->friday_start_time;
              $schedule->end_time  = $request->friday_end_time;
            }
         
            $schedule->status  = 'Available';
            if ($role_id == $agentRoleID) 
            {
              $schedule->role_id  =  $agentRoleID;
            }
            else 
            {
              $schedule->role_id  =  $saleRoleID;
            }
            $schedule->save();
        }
        else {
            $schedule =new Schedule;
            $userID = Auth::id();
            $schedule->user_id =  $userID;
            
            $schedule->day  = 'Friday';
            $schedule->start_time  = "00:00:00";
            $schedule->end_time  = "00:00:00";
            $schedule->status  = 'Not Available';
            if ($role_id == $agentRoleID) 
            {
              $schedule->role_id  =  $agentRoleID;
            }
            else 
            {
              $schedule->role_id  =  $saleRoleID;
            }
            $schedule->save();
        }
        

        if ($request->day_saturday != null) {
            $schedule =new Schedule;
            $userID = Auth::id();
            $schedule->user_id =  $userID;

            $schedule->day  = 'Saturday';
            if ($timezone == "Indian/Mauritius") {
              $start_time =  Carbon::createFromFormat('H:i',$request->saturday_start_time)->addMinutes(180);
              $schedule->start_time  = $start_time;
              
              $end_time =  Carbon::createFromFormat('H:i',$request->saturday_end_time)->addMinutes(180);
              $schedule->end_time  = $end_time;
            }
            
            else {
              $schedule->start_time  = $request->saturday_start_time;
              $schedule->end_time  = $request->saturday_end_time;
            }
          
            $schedule->status  = 'Available';
            if ($role_id == $agentRoleID) 
            {
              $schedule->role_id  =  $agentRoleID;
            }
            else 
            {
              $schedule->role_id  =  $saleRoleID;
            }
            $schedule->save();
        }
        else {
            $schedule =new Schedule;
            $userID = Auth::id();
            $schedule->user_id =  $userID;
            
            $schedule->day  = 'Saturday';
            $schedule->start_time  = "00:00:00";
            $schedule->end_time  = "00:00:00";
            $schedule->status  = 'Not Available';
            if ($role_id == $agentRoleID) 
            {
              $schedule->role_id  =  $agentRoleID;
            }
            else 
            {
              $schedule->role_id  =  $saleRoleID;
            }
            $schedule->save();
        }
       
       
        return Reply::success('messages.createSuccess');
       

        } 
        catch (\Exception $th ) {
            return $th;
        }
        
    }
    

    public function availableDays(Request $request)
    {
      // return $request->all();
        
        try {

        if ($request->has('agent')) 
        {
           $users =  User::with(['staffMembers'=>function($q) use($request){
            $q->where('campaign_id',$request->campaign_id);
           }])->where('sales_member','0')->get();
            
           $role = Role::where('name',strtolower('Agent'))->first();
            $agentRoleID = $role->id; 

            // $days = Schedule::select('id','day','status','user_id','role_id')->where('status','1')
            // ->where('role_id',$agentRoleID )->groupBy('day')->get();
            $days=[];
            foreach($users as $user){
              if (isset($user['staffMembers'])) {
                foreach ($user['staffMembers'] as $members){
                   
                  $d = Schedule::select('id','day','status','user_id','role_id')->where('status',1)
                  ->where('role_id',$agentRoleID)->where('user_id',$members->user_id)->groupBy('day')->get();
                  if ($d != null) {
                    foreach($d as $data){
                      array_push($days,$data);
                    }
                  }
                 
                }
              }
           
            }
            return $days;
        }
        else 
        {
      $users =  SalesMember::with(['staffMembers'=>function($q) use($request){
        $q->where('campaign_id',$request->campaign_id);
       }])->get();

       $role = Role::where('name',strtolower('Sales'))->first();
       $salesRoleID = $role->id; 

       $days=[];
       foreach($users as $user){
         if (isset($user['staffMembers'])) {
          foreach ($user['staffMembers'] as $members){

            $d = Schedule::select('id','day','status','user_id','role_id')->where('status','1')
           ->where('role_id',$salesRoleID)->where('user_id',$members['user_id'] )->groupBy('day')->get();
            foreach($d as $data){
              array_push($days,$data);
            }
            
            }
         }
      
       }
       return $days;
           
        }
             

            
    
        }    catch (\Exception $th ) {
            return $th;
           }
      
    }
    
      /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSchedule(Request $request)
    {
      // return $request->all();
        $updateSchedule =  Schedule::find($request->id);
        $user = Auth::user();
        $timezone = $user->timezone;
        if ($updateSchedule->start_time != $request->start_time ) {
          if ($timezone == "Indian/Mauritius") 
          {
            $start_time =  Carbon::parse($request->start_time)->addMinutes(180);
            $updateSchedule->start_time  = $start_time;
          
          }
          else {
            $updateSchedule->start_time =  $request->start_time;
          }
        }

        if ($updateSchedule->end_time != $request->end_time ) {
          if ($timezone == "Indian/Mauritius") {
            $end_time =  Carbon::parse($request->end_time)->addMinutes(180); 
            $updateSchedule->end_time  = $end_time;
          }
          else {
       
            $updateSchedule->end_time = $request->end_time;
          }
        }
       
       
        
        $updateSchedule->status =  $request->status;
        $updateSchedule->update();

        return Reply::success('messages.updateSuccess');
        

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}