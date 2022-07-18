<?php

namespace App\Jobs;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SettingBoot implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Setting::updateOrCreate([
            'name' => 'general_notifications',
            'value' => null,
        ]);
        Setting::updateOrCreate([
            'name' => 'user_notifications',
            'value' => null,
        ]);
        Setting::updateOrCreate([
            'name' => 'company_notifications',
            'value' => null,
        ]);

    }
}
