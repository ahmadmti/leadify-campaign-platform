<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\CallBack;
use App\Events\AppointmentAlert as Alert;


class AppointmentAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appintment:alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alert 1 min before time';

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
        $date =Carbon::now()->format('Y-m-d');
        $time =Carbon::now()->addMinutes(181);
        $time =  Carbon::parse($time)->format('H:i:s');
    
        $checkDateTime =  $date.' '.$time;
        $checkDateTime =  $date.' '.$time;
        $Appointment = CallBack::find(11);
        $Appointment->callback_time =  $checkDateTime;
    
        $Appointment->update();
    
        // $Appointment = Appointment::find(60);
        // $Appointment->appointment_time =  $checkDateTime;
    
        // $Appointment->update();
    
        $Appointmenttime = Appointment::with('salesMember')->where('appointment_time',$checkDateTime)->get()->toArray();
        
      
        
          foreach ($Appointmenttime as $value) {
             
           
            return  event(new Alert($value['sales_member']['user_id']));
          }

        $CallBacktime = CallBack::with('user')->where('callback_time',$checkDateTime)->get()->toArray();
        
        foreach ($CallBacktime as $value) {
         
    
            return  event(new Alert($value['user']['id']));
          }
         
       }
}
