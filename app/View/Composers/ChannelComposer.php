<?php
 
namespace App\View\Composers;

use App\Models\Channel;
use Illuminate\View\View;
 
class ChannelComposer
{
    protected $channel;
 
    public function __construct(Channel $channel)
    {
        $this->channel = $channel;
    }
 
    public function compose(View $view)
    {
        $view->with('channels', $this->channel->where('is_active', 1)->get());
    }
}
