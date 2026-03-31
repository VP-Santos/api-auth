<?php

use Illuminate\Support\Facades\Schedule;
use App\Jobs\CleanExpiredTokensJob;

Schedule::job(new CleanExpiredTokensJob)->hourly();