<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Statistic;


class StatisticController extends Controller
{
    /**
     * Update the count of clics then redirect the user to an URL.
     *
     * @param  uuid  $uuid
     * @param  \App\Models\Statistic  $statistic
     * @return \Illuminate\Http\Response
     */
    public function redirectUrl($uuid, Statistic $statistic)
    {
        $url = Address::where('uuid', $uuid)->firstOrFail();
        $stat = Statistic::firstOrCreate(
            ['model' => $url->uuid],
            ['count' => 1]
        );
    }
}
