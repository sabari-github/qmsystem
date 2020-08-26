<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarberCreateRequest extends FormRequest
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
        $rules = [
            'name' => 'required|max:25',
            'shop_id' => 'required',
            'email' => 'required|string|email|max:255',
        ];
        if (!($this->request->get('old_image_name'))) {
            $rules['image'] = 'required|image|mimes:png|max:2048';
        }
        if (!($this->request->get('id'))) {
            $rules['email'] = 'required|string|email|max:255|unique:barbers';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => trans('messages.lbl_enter_barber_name_alert'),
            'name.max' => trans('messages.lbl_enter_barber_name_max_alert'),
            'shop_id.required' => trans('messages.lbl_select_shop_name_alert'),
        ];
    }
}
