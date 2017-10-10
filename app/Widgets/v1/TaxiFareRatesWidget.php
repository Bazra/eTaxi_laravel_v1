<?php

namespace App\Widgets\v1;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use App\TaxiFareRate;

class TaxiFareRatesWidget extends AbstractWidget
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
        $count = TaxiFareRate::count();
        $string = 'Available Taxi Fare Rates';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-diamond',
            'title'  => "{$count} {$string}",
            'text'   => __('Taxi Rates According to the roadtypes.'),
            'button' => [
                'text' => 'View All Rates',
                'link' => route('voyager.taxi-fare-rates.index'),
            ],
            'image' => '/etaxi-images/taxi-fare-rate-bg.jpg'
        ]));
    }
}
