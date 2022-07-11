<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\Hour;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller {

    public function index()
    {
        //end goal return only that users companies
        return Inertia::render('Companies/View', [
            'companies' => \App\Models\Company::query()
                ->when(\Illuminate\Support\Facades\Request::input('search'), function($query, $search) {
                    $query->where('name', 'like', "%{$search}%");
                })->userCompanyFilter()
                ->paginate(10)
                ->withQueryString()
                ->through(fn($company) => [
                    'id' => $company->id,
                    'name' => $company->name,
                    'address_1' => $company->address_1,
                    'address_2' => $company->address_2,
                    'city' => $company->city,
                    'county' => $company->county,
                    'postcode' => $company->postcode,
                    'telephone' => $company->telephone,
                    'email' => $company->email,
                    'url' => $company->url,
                ]),
            'filters' => \Illuminate\Support\Facades\Request::only(['search']),
        ]);
    }

    public function create()
    {
        $startTime = '01:00';
        $endTime = '24:00';
        $hours = Hour::hoursBetween($startTime,$endTime);
        $times = Hour::timeToArray($hours, 60, $startTime , $endTime);

        return Inertia::render('Companies/Create', [
            'hours' => $times,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'url' => 'sometimes|nullable',
            'email' => 'sometimes|nullable|email:rfc,dns,spoof,filter',
            'telephone' => 'sometimes|nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
            'postcode' => 'nullable',
        ]);
        $company = \App\Models\Company::create([
            'name' => $request->name,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'city' => $request->city,
            'county' => $request->county,
            'postcode' => $request->postcode,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'url' => $request->url,
        ]);
        $hours = Hour::create([
            'company_id' => $company->id,
            'monday_start' => $request->monday_start ?? '09:00',
            'monday_end' => $request->monday_end ?? '17:00',
            'tuesday_start' => $request->tuesday_start ?? '09:00',
            'tuesday_end' => $request->tuesday_end ?? '17:00',
            'wednesday_start' => $request->wednesday_start ?? '09:00',
            'wednesday_end' => $request->wednesday_end ?? '17:00',
            'thursday_start' => $request->thursday_start ?? '09:00',
            'thursday_end' => $request->thursday_end ?? '17:00',
            'friday_start' => $request->friday_start ?? '09:00',
            'friday_end' => $request->friday_end ?? '17:00',
            'saturday_start' => $request->saturday_star ?? '09:00',
            'saturday_end' => $request->saturday_end ?? '17:00',
            'sunday_start' => $request->sunday_start ?? '09:00',
            'sunday_end' => $request->sunday_end ?? '17:00',

        ]);
        //attach user to the company
        CompanyUser::create([
            'company_id' => $company->id,
            'user_id' => auth()->user()->id,
        ]);

        return to_route('companies.index');
    }

    public function edit(Company $company)
    {

        dd($company);

    }

}
