<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function model(){
        return $this->morphTo(__FUNCTION__, 'loggable_type', 'loggable_id');
    }
    /////////////////////////////////////////////
    ////// Log get and set attributes////////////
    /////////////////////////////////////////////
    public function viewed(): Attribute
    {
        return new Attribute(
            fn($value) => unserialize($value),
            fn($value) => serialize($value),
        );
    }
    /////////////////////////////////////////////
    ////// Gets all viewed Users for this log////
    /////////////////////////////////////////////
    public function viewers()
    {
        $updateSentence = [];
        if($this->viewed != null)
        {
            $users = User::whereIn('id', $this->viewed)->get();
            if($users)
            {
                return implode( ',' , $users->pluck('name')->toArray());
            }
        }
    }
    ////////////////////////////////////////////////
    // Gets all Un-viewed Logs for logged in user///
    ////////////////////////////////////////////////
    public static function unViewed()
    {
        $collection = Collection::empty();

        foreach(Log::with('user')->get() as $log)
        {
            if($log->viewed != null)
            {
                //check's the serialized array called viewed on the logs' table if the user have viewed from the index function
                if(! in_array(auth()->user()->id, $log->viewed))
                {
                    $collection->push($log);
                }
            } else
            {
                $collection->push($log);
            }

        }

        return $collection->take(5);
    }
}
