<?php

namespace Perezale\L5StompQueue;

use \Illuminate\Support\Facades\Facade;

class StompFacade extends Facade {

    protected static function getFacadeAccessor() {
        return 'stomp';
    }
}
