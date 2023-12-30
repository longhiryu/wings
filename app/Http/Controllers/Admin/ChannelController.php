<?php

namespace App\Http\Controllers\Admin;

use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelController extends BaseController
{
    public function __construct()
    {
        $this->model = new Channel();
        parent::__construct();
    }

    public function store(Request $request)
    {
        $data = $request->all();

        return $this->insert_data($data);
    }

    public function update(Request $request, Channel $channel)
    {
        if (request('is_default') == 1) {
            Channel::whereNotIn('id', [$channel->id])->update(['is_default' => false]);
        }

        $data = $request->all();

        return $this->insert_data($data, $channel);
    }
}
