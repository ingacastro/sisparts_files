<?php

namespace IParts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use DB;
use Illuminate\Support\Facades\Log;

class UserRequest extends FormRequest
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
            'user.name' => 'required',
            'user.email' => ['required', 'email', 'unique:users,email'],
            'user.password' => 'required|confirmed|min:6',
            'role_id' => 'required',
            'employee.number' => 'required'
        ];

        $role = DB::table('roles')->find($this->role_id);
        
	if($this->isMethod('post')) {
		if($role && $role->name == 'Cotizador')
            		$rules['employee.buyer_number'] = 'required|unique:employees,buyer_number';
	}

        

        if($this->isMethod('put')) {
            $rules['user.password'] = 'nullable|confirmed|min:6';
            $rules['user.email'] = ['required', 'email'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'user.name.required' => 'El nombre es requerido.',
            'user.email.required' => 'El correo es requerido.',
            'user.email.email' => 'El formato de correo es incorrecto.',
            'user.email.unique' => 'El correo ya existe.',
            'role_id.required' => 'El rol es requerido.',
            'user.password.required' => 'La contraseña es requerida.',
            'user.password.min' => 'La contraseña debe ser de al menos 6 caracteres.',
            'user.password.confirmed' => 'Las contraseñas no coinciden.',
            'employee.number.required' => 'El número de empleado es requerido.',
            'employee.buyer_number.required' => 'El número de cotizador es requerido.'
        ];
    }
}
