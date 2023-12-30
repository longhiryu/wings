<?php
 
namespace App\View\Composers;

use App\Models\Setting;
use Illuminate\View\View;
 
class SettingComposer
{
    protected $setting;
 
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }
 
    public function compose(View $view)
    {
        $view->with('settings', $this->setting::all());
    }
}