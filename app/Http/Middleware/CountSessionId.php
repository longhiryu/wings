<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CountSessionId
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
        // $onlineUsers = [];
        // $currentTime = now();
        // $timeout = 5; // Thời gian (phút) xem người dùng còn online

        // foreach (session()->all() as $sessionId => $value) {
        //     if (strpos($sessionId, 'user-online-') === 0) {
        //         $lastActivity = session($sessionId . '-last-activity');
        //         if ($lastActivity && $currentTime->diffInMinutes($lastActivity) <= $timeout) {
        //             $userId = str_replace('user-online-', '', $sessionId);
        //             $onlineUsers[] = $userId;
        //         }
        //     }
        //     session()->put('user_online', $onlineUsers);
        // $onlineUsersCount = count($onlineUsers);

        return $next($request);
        
        
    }
}
