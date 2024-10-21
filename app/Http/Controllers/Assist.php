<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

/**
 * [amin] this file include all useful functions.
 */

class Assist extends Controller
{
    public static function say_hi($name)
    {
        echo "say hi " . $name;
    }


}
