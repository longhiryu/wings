<?php

namespace App\Http\Controllers\Livewire\Channel;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function setChannel($id){
        if ($id != null && (int) $id) {
            $channel = Channel::find((int) $id);
            if ($channel) {
                session()->put('channel', $channel);
            }
        }

        return back();
    }
}
