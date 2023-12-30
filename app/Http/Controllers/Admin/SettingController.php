<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index()
    {
        $this->authorize('index', new Setting());

        $admin = Setting::where('group', 'admin')->get();
        $website = Setting::where('group', 'website')->get();
        $setting = config('settings');
        $data = [
            'admin' => $admin,
            'website' => $website,
            'setting' => $setting,
        ];

        return view('livewire.admin.setting.index', $data);
    }

    public function update(Request $request)
    {
        $this->authorize('edit', new Setting());

        $data = $request->except('_token', '_method');

        foreach ($data as $key => $value) {
            Setting::updateOrCreate([
                'name' => $key,
            ], [
                'name' => $key,
                'val' => $value,
                'group' => $data['group'],
                'type' => 'text',
            ]);
        }

        return redirect()->back();
    }
}
