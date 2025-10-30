<?php
namespace EvansWanguba\Flexpay\Facades;

use Illuminate\Support\Facades\Facade;

class Flexpay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \EvansWanguba\Flexpay\Contracts\FlexpayClientContract::class;
    }
}
