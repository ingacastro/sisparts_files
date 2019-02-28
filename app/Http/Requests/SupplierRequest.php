<?php

namespace IParts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
              'trade_name' => 'required',
              'countries_id' => 'required',
              'email' => 'required',
              'languages_id' => 'required',
              'landline' => 'required',
              'currencies_id' => 'required',
              'mobile' => 'required',
              'business_name' => 'required',
              'type' => 'required',
              'states_id' => 'required',
              'rfc' => 'required',
              'city' => 'required',
              'post_code' => 'required',
              'street' => 'required',
              'contact_name' => 'required',
              'street_number' => 'required',
              'unit_number' => 'required',
              'credit_days' => 'required',
              'suburb' => 'required',
              'credit_amount' => 'required'
        ];
    }
}
