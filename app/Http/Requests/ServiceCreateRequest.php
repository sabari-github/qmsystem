<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceCreateRequest extends FormRequest
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
            // 'name' => 'required|max:25',
            'name' => 'required',
            'shop_id' => 'required',
            'estimatedtime' => 'required',
        ];
        if (!($this->request->get('old_image_name'))) {
            $rules['image'] = 'required|mimes:jpeg,jpg,png,gif|max:2048';
        }
        if (!$this->request->get('old_id')) {
            $rules['tokenstartfrom'] = 'required|max:25|unique:m_services';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => trans('messages.lbl_enter_service_name_alert'),
            'name.max' => trans('messages.lbl_enter_service_name_max_alert'),
            'shop_id.required' => trans('messages.lbl_select_shop_name_alert'),
        ];
    }
}
