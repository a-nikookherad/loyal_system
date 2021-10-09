<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('custom:migrate', function () {
    \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
    $this->call("migrate");
    \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
});

Artisan::command('fresh', function () {
    \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
    $this->call("migrate:fresh");
    \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
});

Artisan::command('custom:fresh', function () {
    \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
    $this->call("migrate:reset");
    \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
    \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
    $this->call("migrate");
    \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
});

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
