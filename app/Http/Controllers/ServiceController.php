<?php

namespace App\Http\Controllers;

use App\Models\Company;
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
            'duration' => intdiv($service->duration, 60).':'. ($service->duration % 60) . ' Hours',
        ]),
            'filters' => \Illuminate\Support\Facades\Request::only(['search']),
            'company' => $company,
        ]);

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
            'duration' => 'required|int',
        ]);
        Service::create([
            'title' => $request->title,
            'description' => $request->description,
            'company_id' => $company->id,
            'price' => $request->price,
            'duration' => $request->duration,
        ]);

        return to_route('companies.services', $company->id);
    }

}
