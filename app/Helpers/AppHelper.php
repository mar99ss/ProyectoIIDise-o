<?php

namespace App\Helpers;

use App\Models\Movimiento;

// if(session('movimiento') !== null)
//     session('movimiento', Movimiento::all());

class AppHelper {
    static function setActive($routeName) {
        return request()->routeIs($routeName) ? 'active' : '';
    }
}
