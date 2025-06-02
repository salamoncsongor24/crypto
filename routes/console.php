<?php

use App\Domain\Coin\Jobs\QueryPrices;
use App\Domain\Coin\Jobs\SearchForBigSpikes;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new QueryPrices)->everyMinute();
Schedule::job(new SearchForBigSpikes)->dailyAt('6:00');
