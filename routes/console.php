<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('motivation:send')->dailyAt('08:00');
