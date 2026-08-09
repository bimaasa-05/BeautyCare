<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('pesanan:expire')->everyMinute();
Schedule::command('treatment:cek-keterlambatan')->everyMinute();
