<?php
namespace Wanguba\Flexpay\Facades;

use Illuminate\Support\Facades\Facade;

class Flexpay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Wanguba\Flexpay\Contracts\FlexpayClientContract::class;
    }
}
