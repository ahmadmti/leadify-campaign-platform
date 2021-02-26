<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Campaign;
use App\Models\CallBack;
use App\Models\Lead;
use App\Models\User;
use App\Models\SalesMember;
use Carbon\Carbon;
use App\Events\AppointmentAlert;
use Illuminate\Support\Facades\DB;
use Auth;



class BookedAppointmentController extends AdminBaseController
{

      /**
	 * UserController constructor.
	 */

    public function __construct()
    {
        parent::__construct();

        $this->pageTitle = trans('menu.bookedAppointment');
        $this->pageIcon = 'fa fa-calendar-alt';
        $this->appointmentMenuActive = 'active';
        $this->bootstrapModalRight = false;
    }

    public function getBookedAppointments()
   {
       try {
        $this->appointmentBookedActive = 'active';
        $this->bookedAppointments = Appointment::select('sales_members.first_name', 'sales_members.last_name', 'campaigns.id as campaign_id', 'campaigns.name as campaign_name', 'appointments.appointment_time','appointments.meeting_link', 'appointments.sales_member_id', 'appointments.id', 'appointments.lead_id')
       ->join('leads', 'leads.id', '=', 'appointments.lead_id')
       ->join('campaigns', 'campaigns.id', '=', 'leads.campaign_id')
       ->join('sales_members', 'sales_members.id', '=', 'appointments.sales_member_id')
       ->where('sales_members.user_id',Auth::id())
       // ->where('appointments.sales_member_id', 'sales_members.user_id')
       ->where('campaigns.status', '!=', 'completed')
       ->latest('appointments.created_at')
       ->get();
        // return $this->data;
       return view('admin.booked-appointments.index', $this->data);
       } catch (\Exception $th) {
         return $th;
       }
    // return Auth::id();
  
   }

  //  public function getAppointmentsAlerts()
  //  {
  //   $date =Carbon::now()->format('Y-m-d');
  //   $time =Carbon::now()->addMinutes(181);
  //   $time =  Carbon::parse($time)->format('H:i:s');

  //   $checkDateTime =  $date.' '.$time;
  //   $Appointment = CallBack::find(11);
  //   $Appointment->callback_time =  $checkDateTime;

  //   $Appointment->update();

  //   $CallBacktime = CallBack::with('user')->where('callback_time',$checkDateTime)->get()->toArray();
         
  //   // $Appointment = Appointment::find(60);
  //   // $Appointment->appointment_time =  $checkDateTime;

  //   // $Appointment->update();

  //   $Appointmenttime = Appointment::with('salesMember')->where('appointment_time',$checkDateTime)->get()->toArray();
    
  
  //     foreach ($CallBacktime as $value) {
         
    
  //       return  event(new AppointmentAlert($value['user']['id']));
  //     }
     
     

  //  }
}