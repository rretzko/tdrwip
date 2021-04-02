<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Userconfig extends Model
{
    use HasFactory;

    static public function getValue($descr, $user_id)
    {
        return (self::exists($descr,$user_id))
            ? self::get($descr,$user_id)
            : self::default($descr,$user_id);
    }

/** END OF PUBLIC FUNCTIONS **************************************************/

    private static function default($descr, $user_id)
    {
        $method = 'default'.ucfirst($descr);

        self::$method($descr, $user_id);

        return self::get($descr, $user_id);
    }

    private static function defaultSave($descr, $user_id, $value)
    {
        DB::table('userconfigs')
            ->insert([
                'descr' => $descr,
                'user_id' => $user_id,
                'value' => $value,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
    }

    private static function defaultSchool_id($descr, $user_id)
    {
        $user = User::find($user_id);
        $school = $user->schools->first();
        self::defaultSave($descr, $user_id, $school->id);
    }

    private static function exists($descr, $user_id)
    {
        return DB::table('userconfigs')
            ->where('user_id', '=', $user_id)
            ->where('descr', '=', $descr)
            ->exists();
    }

    private static function get($descr, $user_id)
    {
        return DB::table('userconfigs')
            ->where('user_id', '=', $user_id)
            ->where('descr', '=', $descr)
            ->value('value');
    }
}
