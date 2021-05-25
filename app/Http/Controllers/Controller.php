<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const Strategies = [
        'ringall'        => 'Ring all in list',
        'hunt'           => 'Ring one at a time',
        'firstavailable' => 'Ring first available user',
        'random'         => 'Randomly selects users untill answer'
    ];

    const WEEK_DAYS = [
        'mon' => 'Monday',
        'tue' => 'Tuesday',
        'wed' => 'Wednesday',
        'thu' => 'Thursday',
        'fri' => 'Friday',
        'sat' => 'Saturday',
        'sun' => 'Sunday'
    ];

    const Destination = [
        'from-did-direct'  => 'Extension',
        'app-announcement' => 'Announcement',
        'ivr'              => 'Auto Attendant',
        'timeconditions'   => 'Time Condition',
        'ext-group'        => 'Department',
        'app-blackhole'    => 'Hang up call',
        'ext-local'        => 'Voice Mail',
    ];

    const VOICE_MAIL_MESSAGES = [
        'vmu' => 'Unavailable Message',
        'vmb' => 'Busy Message',
        'vms' => 'No Message',
        'vmi' => 'Instructions Only',
    ];

}
