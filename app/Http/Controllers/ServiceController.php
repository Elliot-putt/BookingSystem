<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Hour;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceController extends Controller {

    public function index(Company $company)
    {
        return Inertia::render('Services/View', [
            'services' => $company->services
                ->when(\Illuminate\Support\Facades\Request::input('search'), function($query, $search) {
                    $query->where('title', 'like', "%{$search}%");
                })
                ->map(fn($service) => [
                    'id' => $service->id,
                    'title' => $service->title,
                    'company_id' => $service->comapny_id,
                    'company_name' => $service->company->name,
                    'description' => $service->description,
                    'price' => $service->price,
                    'duration' => intdiv($service->duration, 60) . ':' . ($service->duration % 60) . ' Hours',
                ]),
            'filters' => \Illuminate\Support\Facades\Request::only(['search']),
            'company' => $company,
        ]);

    }

    public function searchServices()
    {
        //return a page to look for all services search bar
        return Inertia::render('Services/All');
    }

    public function create(Company $company)
    {
        return Inertia::render('Services/Create', [
            'company' => $company,
            'services' => $company,
        ]);
    }

    public function store(Company $company, Request $request)
    {

        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'int|nullable',
            'duration' => 'nullable|int',
            'allDay' => 'nullable|boolean',
        ]);
        $service = new Service();
        $service->title = $request->title;
        $service->description = $request->description;
        $service->company_id = $company->id;
        $service->price = $request->price;
        if($request->allDay != false)
        {
            $service->duration = $request->duration;
        }
        $service->save();

        return to_route('companies.services' , $company->id);

    }

}
