<?php

namespace App\Helpers;

use App\Models\School;
use Illuminate\Support\Str;

class SchoolHelper {
    public static function generate_code()
    {
        $code = Str::random(8);
        $school = School::where('code', $code)->first();
        if ($school) self::generate_code();
        return $code;
    }
}
