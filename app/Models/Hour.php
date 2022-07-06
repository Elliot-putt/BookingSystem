<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hour extends Model {

    use HasFactory;

    protected $guarded = [];

    public static function hoursBetween(string $start, string $end): int
    {
        $hours =
            Carbon::parse('06' . '/' . '01/' . '2022' . $start)
                ->diff(Carbon::parse('06' . '/' . '01/' . '2022' . $end))->format('%H');

        return floatval($hours);
    }

    public static function timeToArray(int $hours = 24, $duration, string $start, string $end): array
    {
        $minuetsInDay = $hours * 60;
        $intervalsInDay = ceil($minuetsInDay / $duration);
        $times = [];

        $i = 0;
        while($intervalsInDay > $i)
        {
            $i++;
            if(end($times) && Carbon::parse(end($times))->addMinutes($duration)->format('H:i') <= $end)
            {
                $lastTime = Carbon::parse(end($times))->addMinutes($duration)->format('H:i');
                $times[] = $lastTime;
            } else if(! end($times))
            {
                $itemFirst = Carbon::parse($start)->format('H:i');
                $times[] = $start;
                $itemSecond = Carbon::parse($start)->addMinutes($duration)->format('H:i');
                $times[] = $itemSecond;
            }

        }

        return $times;
    }

}
