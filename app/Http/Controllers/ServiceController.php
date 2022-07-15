<?php

namespace App\Http\Controllers;

use App\Jobs\FileUpload;
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
                    'duration' => intdiv($service->duration, 60) . ':' . ($service->duration % 60) . ' Hour(s)',
                    'quantity' => $service->quantity,
                    'allDay' => $service->allDay(),
                    'hasDuration' => $service->hasDuration(),
                    'requiresDuration' => $service->requiresDuration(),
                    'popularity' => $service->popularity(),
                    'photo' => $service->Photo(),
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

        ]);
    }

    public function store(Company $company, Request $request)
    {

        $request->validate([
            'title' => 'required|string',
            'file' => 'nullable|image|mimes:jpeg,jpg,png,bmp,gif,svg',
            'description' => 'required|string',
            'price' => 'int|nullable',
            'duration' => 'nullable|int',
            'defaultDuration' => 'nullable|boolean',
            'fullDay' => 'nullable|boolean',
            'quantity' => 'nullable|int',
        ]);

        $service = new Service();
        $service->title = $request->title;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->quantity = $request->quantity;
        $service->company_id = $company->id;

        $file = [];
        $file[] = $request->file;
        if($request->file)
        {
            //remove the current profile picture
            if($service->hasMedia('Service'))
            {
                $fileId = $service->getFirstMedia('Service')->id;
                MediaController::fileDeleteMethod($fileId);
            }
            // This uploads Profile images to a users profile
            dispatch(new FileUpload($file, $service, 'Service'))->onQueue('low')->afterResponse();
        }

//        defaultDuration being false means on creating a booking there will need to be a duration
//        defaultDuration being true means a duration will need providing on the service create screen
        if($request->fullDay === true && $request->defaultDuration === false)
        {
            $service->duration = null;
            $service->full_day = false;
        }
        //false is backwards so if user input is false its selected
        //if full day isn't checked duration is empty and the user needs to input a service duration
        if($request->defaultDuration === false)
        {
            //duration will be empty as users will input how long they need
            $service->duration = null;
            $service->full_day = false;
        }
        if($request->fullDay === true && $request->defaultDuration === true)
        {
            //duration will be empty as users will input how long they need
            $service->duration = null;
            //if the user is inputting the service time it cannot be all day
            $service->full_day = true;
        }
        if($request->fullDay === false && $request->duration !== null)
        {
            //enter how long the default duration will be
            $service->duration = $request->duration;
            //if the user is inputting the service time it cannot be all day
            $service->full_day = false;
        }
        $service->save();

        return to_route('companies.services', $company->id);

    }

}
