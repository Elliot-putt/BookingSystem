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
        return $this->hasMany(Service::class, 'company_id');
    }

    public function bookings()
    {
        return Booking::where('company_id', '=', $this->id);
    }

    public function scopeUserCompanyFilter($query)
    {
        $company_ids = auth()->user()->companiesArray();

        return $query->whereIn('id', $company_ids);
    }
    public function members()
    {
        return $this->belongsToMany(User::class, 'company_users' );
    }
    public function workingHours($day){
        $filtered = [];
        $hours = $this->hours->toArray();
        $key_1 = $day . '_start';
        $key_2 = $day . '_end';
        //set keys to monday_end to find them in the array
        $filtered[$key_1] = '';
        $filtered[$key_2] = '';
       return array_intersect_key($hours, $filtered);
    }

}
