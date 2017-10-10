<?php

namespace App\Widgets\v1;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use App\Passenger;

class PassengersWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
   public function run()
    {
        $count = Passenger::count();
        $string = 'Passengers';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-people',
            'title'  => "{$count} {$string}",
            'text'   => __('Registered Passengers'),
            'button' => [
                'text' => 'View All Passengers',
                'link' => route('voyager.passengers.index'),
            ],
            'image' => '/etaxi-images/taxi-passenger-bg.jpg'
        ]));
    }
}
