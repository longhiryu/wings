<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'phone' => 'numeric|min:10',            
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên',
            'name.min' => 'Tên quá ngắn (ít nhất phải 4 ký tự)',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email chưa đúng định dạng',
            'password.required' => 'Vui lòng nhập password',
            'password.confirmed' => 'Xác thực mật khẩu chưa khớp',
            'password.min' => 'Mật khẩu ít nhất phải có 6 ký tự',
            'phone.numeric' => 'Số điện thoại phải là dạng số',
            'phone.min' => 'Số điện thoại ít nhất phải có 10 ký tự'
        ];
    }
}
