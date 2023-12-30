<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // get all channels for select channel
        $channels = Channel::all();
        session()->put('channels', $channels);

        // check if no channel selected
        if (! session()->has('channel')) {
            $channels = session()->get('channels');
            // get default channel
            $channel = $channels->filter(function ($item) {
                return $item->is_default == 1;
            })->first();

            session()->put('channel', $channel);
        }

        return $next($request);
    }
}
