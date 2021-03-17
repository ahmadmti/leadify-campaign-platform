<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';

    
    protected $dates = ['appointment_time'];

    public function salesMember()
    {
        return $this->hasOne('App\Models\SalesMember',  'id','sales_member_id');
    }
    public function user()
    {
        return $this->hasOne('App\Models\User',  'id','created_by');
    }
    public function lead()
    {
        return $this->hasOne(Lead::class, 'id', 'lead_id');
    }
}
