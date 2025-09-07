<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('email:send-maximum-prize')->dailyAt('14:13');
