<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreatePartnerRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'company_name' => 'required',
            // 'short_name' => 'required',
            'phone' => 'numeric',
            'email' => 'email',            
            'tax_no' => 'numeric',
        ];
    }
    public function attributes()
    {
        return [
            'name' => trans('partner.name'),
            'company_name' => trans('partner.company'),
            'short_name' => trans('partner.short_name'),
            'phone' => trans('partner.phone'),
            'email' => trans('partner.email'),
            'address' => trans('partner.address'),
            'tax_no' => trans('partner.tax'),
        
        ];
    }
    public function messages()
    {
        return [
            'required' => ":attribute là bắt buộc",
            'numeric' => ":attribute phải là một số",
        ];
    }
}
