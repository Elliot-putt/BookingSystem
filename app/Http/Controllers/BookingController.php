<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Company;
use App\Models\Hour;
use App\Models\Service;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use function PHPUnit\Framework\stringContains;

class BookingController extends Controller {

    public function all()
    {

        $collection = Booking::query()->whereUserId(auth()->user()->id)->paginate(10)
            ->withQueryString()->map(fn($booking) => [
                'month' => Carbon::parse($booking->date_booked)->format('F'),
                'day' => Carbon::parse($booking->date_booked)->format('d'),
                'time' => Carbon::parse($booking->date_booked)->format('H:i'),
                'company_id' => $booking->company_id,
                'company_name' => $booking->company->name,
                'company' => $booking->company,
                'service_id' => $booking->service_id,
                'user_id' => $booking->user_id,
                'status' => $booking->status,
                'ref' => $booking->ref,
                'serviceName' => $booking->service->title,

            ]);

        return Inertia::render('Bookings/View', [
            'bookings' => $collection,
        ]);
    }

    //returns current or selected dates to the user
    public function index(Company $company, Service $service, $month = null, $year = null)
    {
        if(! $month) $month = Carbon::now()->format('m');
        if(! $year) $year = Carbon::now()->format('Y');

        $now = Carbon::parse($month . '/' . '01/' . $year);
        $startOfMonthDay = Carbon::parse($month . '/' . '01/' . $year)->startOfMonth();
        $startDays = $startOfMonthDay->format('w');

        if($startDays == 0)
        {
            $startDays = 6;
        } else
        {
            $startDays--;
        };
        $daysInMonth = floatval(Carbon::parse($month . '/' . '01/' . $year)->endOfMonth()->format('j'));
        $days = [];
        $i = 1;
        while($daysInMonth > $i)
        {
            $days [] = sprintf("%02d", $i);
            $i++;
        }

        return Inertia::render('Bookings/Create', [
            'nextMonth' => Carbon::parse($month . '/' . '01/' . $year)->addMonth()->format('m'),
            'nextYear' => Carbon::parse($month . '/' . '01/' . $year)->addMonth()->format('Y'),
            'prevMonth' => Carbon::parse($month . '/' . '01/' . $year)->subMonth()->format('m'),
            'prevYear' => Carbon::parse($month . '/' . '01/' . $year)->subMonth()->format('Y'),
            'startDays' => floatval($startDays),
            'today' => Carbon::now()->format('d') . Carbon::now()->format('m') . Carbon::now()->format('Y'),
            'isPast' => $now->isPast(),
            'now' => $now->format('Y/M'),
            'month' => $now->format('m'),
            'monthName' => $now->format('F'),
            'year' => $now->format('Y'),
            'daysAmount' => $days,
            'company' => $company,
            'service' => $service,
        ]);
    }

    //returns time slots to view
    public function timeSlots(Company $company, Service $service, $day = null, $month = null, $year = null)
    {
        if(! $month) $month = Carbon::now()->format('m');
        if(! $year) $year = Carbon::now()->format('Y');
        if(! $day) $day = Carbon::now()->format('d');

        $dayDigit = $day;
        $now = Carbon::parse($month . '/' . $day . '/' . $year);
        $queryDate = Carbon::parse($month . '/' . $dayDigit . '/' . $year);

        $day = strtolower(Carbon::parse($month . '/' . $day . '/' . $year)->format('l'));
        $filtered = [];
        $hours = $company->hours->toArray();
        $key_1 = $day . '_start';
        $key_2 = $day . '_end';
        //set keys to monday_end to find them in the array
        $filtered[$key_1] = '';
        $filtered[$key_2] = '';
        $dayHours = array_intersect_key($hours, $filtered);

        if($dayHours)
        {
            //get all the hours within the companies addressed working hours from the database and push to an array
            $hoursInDay = Hour::hoursBetween($dayHours[$key_1], $dayHours[$key_2]);
            $times = Hour::timeToArray($hoursInDay, $service->duration, $dayHours[$key_1], $dayHours[$key_2]);
            //if it's the current day offset the array with how many hours the day has been through the working day
            if($queryDate->isCurrentDay())
            {
                $hourTillPresent = Hour::hoursBetween($dayHours[$key_1], Carbon::now()->addHour()->format('H:i'));
                $timesSoFar = Hour::timeToArray($hourTillPresent, $service->duration, $dayHours[$key_1], $dayHours[$key_2]);
                $times = array_diff_key($times, $timesSoFar);
            }
            //Check if there are any times returned ? if so this function removes all the currently booked slots and times
            if($times)
            {
                //map over the collection and change the dates to 2022-12-29, so we can string match them for the same day
                $queryBookings = $service->bookings->map(fn($booking) => [
                    'date_booked' => Carbon::parse($booking->date_booked)->format('Y-m-d'),
                    'time_booked' => Carbon::parse($booking->date_booked)->format('H:i'),
                ])->where('date_booked', '=', $queryDate->format('Y-m-d'));
                //foreach all the bookings for the queried date and unset them, so they can tbe selected
                foreach($queryBookings as $booking)
                {
                    // get time 09:00 unset this against all the times for the day $times
                    $arrayKey = array_search($booking['time_booked'], $times);
                    unset($times[$arrayKey]);
                }
            }
        }
        $startDays = Carbon::parse($month . '/' . '01/' . $year)->startOfMonth()->format('w');
        if($startDays == 0)
        {
            $startDays = 6;
        } else
        {
            $startDays--;
        }

        $days = [];
        $i = 1;
        while(floatval(Carbon::parse($month . '/' . '01' . '/' . $year)->endOfMonth()->format('j')) > $i)
        {
            $days [] = sprintf("%02d", $i);
            $i++;
        }

        return Inertia::render('Bookings/Create', [
            'nextMonth' => Carbon::parse($month . '/' . $dayDigit . '/' . $year)->addMonth()->format('m'),
            'nextYear' => Carbon::parse($month . '/' . $dayDigit . '/' . $year)->addMonth()->format('Y'),
            'prevMonth' => Carbon::parse($month . '/' . $dayDigit . '/' . $year)->subMonth()->format('m'),
            'prevYear' => Carbon::parse($month . '/' . $dayDigit . '/' . $year)->subMonth()->format('Y'),
            'startDays' => floatval($startDays),
            'today' => Carbon::now()->format('d') . Carbon::now()->format('m') . Carbon::now()->format('Y'),
            'isPast' => $now->isPast(),
            'now' => $now->format('Y/M'),
            'month' => $now->format('m'),
            'monthName' => $now->format('F'),
            'year' => $now->format('Y'),
            'daysAmount' => $days,
            'company' => $company,
            'service' => $service,
            'times' => $times,
            'dateBooked' => $month . '/' . $dayDigit . '/' . $year,
        ]);
    }

    public function store(Company $company, Service $service, Request $request)
    {
        $date = $request->date . ' ' . $request->time;
        $booking = Booking::create([
            'company_id' => $company->id,
            'service_id' => $service->id,
            'user_id' => auth()->user()->id,
            'ref' => time() . '-' . auth()->user()->id,
            'date_booked' => Carbon::parse($date),
            'status' => 0,
        ]);

        //send an email

        return to_route('booking.all');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Booking $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Booking $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Booking      $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Booking $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }

}
