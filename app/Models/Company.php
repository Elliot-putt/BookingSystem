<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model {

    use HasFactory;

    protected $guarded = [];

    public function hours()
    {
        return $this->hasOne(Hour::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class , 'company_id');
    }
    public function bookings()
    {
        return Booking::where('company_id', '=', $this->id);
    }

}
