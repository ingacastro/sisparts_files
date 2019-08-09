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
        $rules = [
              'trade_name' => 'required',
              'countries_id' => 'required',
              'type' => 'required',
              'languages_id' => 'required'
            ];

        $no_marketplace_rules = [
              //'currencies_id' => 'required',
              'mobile' => 'nullable|max:15',
              //'marketplace' => 'required',
              //'business_name' => 'required',
              //'states_id' => 'required',
              'rfc' => ['nullable', 'regex:/^[a-zA-Z]{3,4}(\d{6})((\D|\d){2,3})?$/'],
              //'city' => 'required',
              'post_code' => 'required',
              //'street' => 'required',
              //'contact_name' => 'required',
              //'street_number' => 'required',
              //'unit_number' => 'required',
              'credit_days' => 'nullable|numeric',
              //'suburb' => 'required',
              'credit_amount' => 'nullable|numeric',
              'email' => 'required|email',
              'landline' => 'required|max:15'
        ];

        //only for no marketplace suppliers
        if(!$this->has('marketplace')){
          $rules = array_merge($rules, $no_marketplace_rules);
        }

        //if($this->isMethod('post')) $rules['rfc'][] = 'unique:suppliers';

        return $rules;
    }

    public function messages()
    {
      return [
        'trade_name.required' => 'El nombre comercial es requerido.',
        'countries_id.required' => 'El país es requerido.',
        'email.required' => 'El correo electrónico es requerido.',
        'email.email' => 'El formato del correo electrónico es incorrecto.',
        'languages_id.required' => 'El idioma es requerido.',
        'landline.required' => 'El teléfono fijo es requerido.',
        'landline.max' => 'El formato de teléfono debe ser de máximo 15 caracteres.',
        'currencies_id.required' => 'La moneda es requerida.',
        'mobile.required' => 'El teléfono móvil es requerido.',
        'mobile.max' => 'El formato de teléfono debe ser de máximo 15 caracteres.',
        //'marketplace.required' => 'El marketplace es requerido.',
        'business_name.required' => 'La razón social es requerido.',
        'type.required' => 'El tipo de proveedor es requerido.',
        'states_id.required' => 'El estado es requerido.',
        'rfc.required' => 'El RFC requerido.',
        'rfc.unique' => 'El RFC indicado ya existe.',
        'rfc.regex' => 'El formato de RFC es incorrecto.',
        'city.required' => 'La ciudad es requerido.',
        'post_code.required' => 'El código postal es requerido.',
        'post_code.size' => 'El código postal debe ser de 5 dígitos.',
        'street.required' => 'La calle es requerida.',
        'contact_name.required' => 'El contacto es requerido.',
        'street_number.required' => 'El número exterior es requerido.',
        'unit_number.required' => 'El número interior es requerido.',
        'credit_days.required' => 'Los días de crédito es requerido.',
        'credit_days.required' => 'Los días de crédito debe ser númerico.',
        'suburb.required' => 'La colonia es requerida.',
        'credit_amount.required' => 'El monto de crédito es requerido.',
        'credit_amount.required' => 'El monto de crédito debe ser númerico.'
      ];
    }
}
