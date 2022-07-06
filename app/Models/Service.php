<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model {

    use HasFactory;

    protected $guarded = [];

    public function excerpt(){
        return str($this->description)->ltrim(20) . ' ...';
    }
    public function company(){
        return $this->belongsTo(Company::class);
    }
    public function bookings(){
        return $this->hasMany(Booking::class);
    }

}
