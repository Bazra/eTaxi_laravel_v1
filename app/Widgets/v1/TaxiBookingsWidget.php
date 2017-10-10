<?php

namespace App\Widgets\v1;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use App\TaxiBooking;

class TaxiBookingsWidget extends AbstractWidget
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
        $count = TaxiBooking::count();
        $string = 'Taxi Bookings';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-book',
            'title'  => "{$count} {$string}",
            'text'   => __('Taxi Bookings in the System.'),
            'button' => [
                'text' => 'View All Taxi Bookings',
                'link' => route('voyager.taxi-bookings.index'),
            ],
            'image' => '/etaxi-images/taxi-booking-bg.png'
        ]));
    }
}
