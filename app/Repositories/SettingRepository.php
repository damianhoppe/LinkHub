<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;

class SettingRepository {

    public function find($param): string {
        $results = DB::select('SELECT * FROM settings WHERE param=?', [$param]);
        if(sizeof($results) > 0)
            return $results[0]->value;
        return Config::get('settings.' . $param);
    }
}