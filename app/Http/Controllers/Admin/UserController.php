<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\UserCreateRequest;
use App\Http\Requests\Admin\UserUpdateRequest;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->model = new User();
        parent::__construct();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        if ($request->get('password') != $request->get('confirm_password')) {
            // confirm password not match
            return redirect()->back()->with('error', 'Password and confirm password does not match.');
        }

        if ($request->get('password') == '') {
            // password empty
            return redirect()->back()->with('error', 'Password can not empty.');
        }

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        $new = User::create($data);

        return redirect()->route('user.edit', $new->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->all();
        $user->update($data);

        return redirect()->route('user.edit', $user->id);
    }

    /**
     * Validate and update the user's password.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function updatePassword(Request $request)
    {
        // if (! (Hash::check($request->get('current-password'), Auth::user()->password))) {
        //     return redirect()->back()->with('error', 'Your current password does not matches with the password.');
        // }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            // Current password and new password same
            return redirect()->back()->with('error', 'New Password cannot be same as your current password.');
        }

        $validatedData = $request->validate([
            //'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        //Change Password
        $password = Hash::make($request->get('new-password'));
        User::where('id', $request->id)->update(['password' => $password]);

        return redirect()->back()->with('success', 'Password successfully changed!');
    }
}
