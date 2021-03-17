<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\EmailTemplate;
use App\Models\LeadData;
use App\Notifications\SendMeetingLink;
use Illuminate\Support\Facades\Notification;
use App\Models\SalesMember;

class NotifyUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
     
          
            $sendEmailTemplate = EmailTemplate::where('id',5)->first();
        
           	 $date =Carbon::now()->format('Y-m-d');
            $time =Carbon::now()->addMinutes(30);
            $time =  Carbon::parse($time)->format('H:i:s');
            $checkDateTime =  $date.' '.$time;
            $checkDateTime =  $date.' '.$time;
            $Appointmenttime = Appointment::with('salesMember')->where('appointment_time',$checkDateTime)->get()->toArray();
       
         foreach ($Appointmenttime as $value) {
            $leadDatas = LeadData::where('lead_id',  $value['lead_id'])->where('field_name','Email')->first();
	   $templateContent = $sendEmailTemplate->content ;

           if ($leadDatas->field_value) {
            $clientEmail = $leadDatas->field_value;
            Notification::route('mail',$clientEmail )->notify(new SendMeetingLink($sendEmailTemplate->subject, $templateContent ));
    
           }
            Notification::route('mail', $value['sales_member']['email'])->notify(new SendMeetingLink($sendEmailTemplate->subject, $templateContent ));
       
          }
        
 
    }
}
