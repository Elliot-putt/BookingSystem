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
        //filter by coming first
        //paginate
        //add search
        return Inertia::render('Bookings/View', [
            'booking' => \App\Models\Booking::query()
                ->when(\Illuminate\Support\Facades\Request::input('search'), function($query, $search) {
                    $query->where('ref', 'like', "%{$search}%");
                })->orderBy('date_booked', 'ASC')
                ->paginate(10)
                ->withQueryString()
                ->through(fn($booking) => [
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
                    'id' => $booking->id,
                ]),
            'filters' => \Illuminate\Support\Facades\Request::only(['search']),
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
            'duration' => is_numeric(\request('duration')) ? floor(\request('duration')) : floor(60),
        ]);
    }

    //returns time slots to view
    public function timeSlots(Company $company, Service $service, $day = null, $month = null, $year = null, $duration = null)
    {
        if(! $month) $month = Carbon::now()->format('m');
        if(! $year) $year = Carbon::now()->format('Y');
        if(! $day) $day = Carbon::now()->format('d');

        $dayDigit = $day;
        $now = Carbon::parse($month . '/' . $day . '/' . $year);
        $queryDate = Carbon::parse($month . '/' . $dayDigit . '/' . $year);

        $day = strtolower(Carbon::parse($month . '/' . $day . '/' . $year)->format('l'));

        if($service->requiresDuration())
        {
            //all company bookings for that day
            //change $service to $company if you want the bookings to be whole company related not service related
            $bookings = $service->bookings()->get()->map(fn($booking) => [
                'date_booked' => Carbon::parse($booking->date_booked)->format('Y-m-d'),
                'start_time' => Carbon::parse($booking->date_booked)->addMinute()->format('Y-m-d H:i'),
                'end_time' => Carbon::parse($booking->date_booked)->addMinutes($booking->duration)->format('Y-m-d H:i'),
                'time_booked' => Carbon::parse($booking->date_booked)->format('H:i'),
                'service_duration' => $booking->duration,
            ])->where('date_booked', '=', $queryDate->format('Y-m-d'));
        }
        if($service->hasDuration() || $service->allDay())
        {
            //all company bookings for that day
            //change $service to $company if you want the bookings to be whole company related not service related
            $bookings = $service->bookings()->get()->map(fn($booking) => [
                'date_booked' => Carbon::parse($booking->date_booked)->format('Y-m-d'),
                'start_time' => Carbon::parse($booking->date_booked)->format('Y-m-d H:i'),
                'end_time' => Carbon::parse($booking->date_booked)->addMinutes($booking->duration)->format('Y-m-d H:i'),
                'time_booked' => Carbon::parse($booking->date_booked)->format('H:i'),
                'service_duration' => $booking->service->duration,
            ])->where('date_booked', '=', $queryDate->format('Y-m-d'));
        }

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
            $times = Hour::timeToArray($hoursInDay, 15, $dayHours[$key_1], $dayHours[$key_2]);
            //Check if there are any times returned if so this function removes all the currently booked slots and times
            if($times)
            {
                //if duration is default then set it as it will use the default of 60 minutes if not
                if($service->hasDuration())
                {
                    $duration = $service->duration;
                }
                //if there is a quantity count how many bookings there are between the booking time and if it goes over quantity show no more
                if($service->hasDuration() || $service->requiresDuration())
                {
                    //foreach all the bookings for the queried date and unset them, so they can tbe selected
                    foreach($bookings as $booked)
                    {
                        //foreach time '09:00' check if the time is between the available hours and if the booking is unset the time
                        foreach($times as $time)
                        {
                            $t = \Carbon\Carbon::parse($now->format('Y-m-d') . ' ' . $time);
                            $bookingTime = Carbon::createFromTimeString($booked['time_booked'])->subMinute();
                            $afterDuration = Carbon::createFromTimeString($booked['time_booked'])->addMinutes($booked['service_duration'])->subMinute();
                            $timeFromString = Carbon::createFromTimeString($time);
                            $bookingsBetweenTime = $bookings->where('start_time', '<=', $t)->where('end_time', '>=', $t)->count();

                            if($service->quantity && $duration)
                            {
                                //get all booking between the foreach time to get the count to compare it against the quantity if its over or equal remove the slot
                                if($bookingsBetweenTime >= $service->quantity)
                                {
                                    unset($times[array_search($time, $times)]);
                                }
                                //if there is no quantity field then if there is a booking between he foreach time and booking remove it
                            } else if(! $service->quantity)
                            {
                                if($timeFromString->isBetween($bookingTime, $afterDuration))
                                {
                                    unset($times[array_search($time, $times)]);
                                }
                            }
                            //This code below is for custom duration booking which finds any booking between the foreach time and foreach time + duration against the  start time if there is remove the time.
                            if($bookings->whereBetween('start_time', [Carbon::parse($booked['date_booked'] . ' ' . $time), Carbon::parse($booked['date_booked'] . ' ' . $time)->addMinutes($duration)])->count() > 0)
                            {
                                unset($times[array_search($time, $times)]);
                            }
                        }
                    }
                }
            }
            //if it's the current day offset the array with how many hours the day has been through the working day -- all types do this
            if($queryDate->isCurrentDay())
            {
                //if the time now is before the hours start time of the business ignore it
                if(! Carbon::parse(now()->addHour())->isBefore(now()->format('m/d/Y') . ' ' . $dayHours[$key_1]))
                {
                    $hourTillPresent = Hour::hoursBetween($dayHours[$key_1], Carbon::now()->addHour()->format('H:i'));
                    $timesSoFar = Hour::timeToArray($hourTillPresent, 15, $dayHours[$key_1], $dayHours[$key_2]);
                    $times = array_diff_key($times, $timesSoFar);
                }
            }
            //checks if the duration runs over the closing time of the company if so remove it
            foreach($times as $time)
            {
                $queryTime = Carbon::parse($queryDate->format('m/d/Y') . ' ' . $time);
                $endTime = Carbon::parse($queryDate->format('m/d/Y') . ' ' . $dayHours[$key_2]);
                if($queryTime->addMinutes($duration)->isAfter($endTime))
                {
                    $arrayKey = array_search($time, $times);
                    unset($times[$arrayKey]);
                }
            }
        }
        //this is for the all day bookings to pass through
        if($service->allDay())
        {
            $quantity = $service->quantity;
            //check if there's a quantity if so check how many bookings there are so far
            if($quantity)
            {
                //if there are less booking than quantity do below
                if($bookings->count() < $quantity)
                {
                    $availability = $quantity - $bookings->count();
                    // return as $times single item array saying 5 slots available
                    $times = [0 => "$availability Items left for booking for $dayHours[$key_1] until $dayHours[$key_2]"];

                } else
                {
                    //setting the times to an empty array enables the v-else on the view to show there are no bookings
                    $times = [];
                }

            }
            //gets single items for all day bookings
            if(! $quantity)
            {
                if($bookings->count() < 1)
                {
                    $times = [0 => "Item available for {$dayHours[$key_1]} until  {$dayHours[$key_2]}"];
                } else
                {
                    //setting the times to an empty array enables the v-else on the view to show there are no bookings
                    $times = [];
                }
            }

        }

        //gets the days of the week to offset it with
        $startDays = Carbon::parse($month . '/' . '01/' . $year)->startOfMonth()->format('w');
        if($startDays == 0)
        {
            $startDays = 6;
        } else
        {
            $startDays--;
        }

        //adds a 0  to the date format instead of 9062022 it would append a 0 like 09062022
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
            'day' => $dayDigit,
            'daysAmount' => $days,
            'company' => $company,
            'service' => $service,
            'times' => $times,
            'dateBooked' => $month . '/' . $dayDigit . '/' . $year,
            'duration' => $duration,

        ]);
    }

    public function store(Company $company, Service $service, Request $request)
    {

        if($service->allDay())
        {
            $date = $request->date;
        } else
        {
            $date = $request->date . ' ' . $request->time;
        }
        $booking = Booking::create([
            'company_id' => $company->id,
            'service_id' => $service->id,
            'user_id' => auth()->user()->id,
            'ref' => time() . '-' . auth()->user()->id,
            'date_booked' => Carbon::parse($date),
            'duration' => $request->duration,
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

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return to_route('booking.all');
    }

}
