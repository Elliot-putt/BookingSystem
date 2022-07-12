<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

class Service extends Model {

    use HasFactory;

    protected $guarded = [];

    public function excerpt()
    {
        return str($this->description)->ltrim(20) . ' ...';
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    //checks if the user is allowed to input how long they need the service for
    public function requiresDuration()
    {
        if($this->duration == null && $this->full_day == false)
        {
            return true;
        } else
        {
            return false;
        }
    }
    //Checks if the service is for all day
    public function allDay()
    {
        if($this->duration == null && $this->full_day == true)
        {
            return true;
        } else
        {
            return false;
        }
    }
    //checks if the user is allowed to input how long they need the service for
    public function hasDuration()
    {
        if($this->duration !== null && $this->full_day == false)
        {
            return true;
        } else
        {
            return false;
        }
    }

}
