<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSettingsRequest;

class SettingsController extends Controller {

    public function update(Request $request, string $param) {
        $value = $request->input('value');
        $setting = Settings::where('param', $param)->firstOrNew();
        if(!$setting->exists)
            $setting->param = $param;
        $setting->value = $value;
        $setting->save();
        return redirect('/');
    }
}
