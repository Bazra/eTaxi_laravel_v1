<?php

namespace App\Widgets\v1;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use App\Driver;

class DriversWidget extends AbstractWidget
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
        $count = Driver::count();
        $string = 'Drivers';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-truck',
            'title'  => "{$count} {$string}",
            'text'   => __('Registered Drivers'),
            'button' => [
                'text' => 'View All Drivers',
                'link' => route('voyager.drivers.index'),
            ],
            'image' => '/etaxi-images/taxi-driver-bg.jpg'
        ]));
    }
}
