<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model {

    use HasFactory;

    protected $guarded = [];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function scopeToDate($query, $date)
    {

    }

}
