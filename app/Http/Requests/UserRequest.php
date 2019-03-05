<?php

namespace IParts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'user.name' => 'required',
            'user.email' => ['required', 'email', 'unique:users,email'],
            'user.password' => 'required|confirmed|min:6',
            'role' => 'required',
            'employee.number' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'user.name.required' => 'El nombre es requerido.',
            'user.email.required' => 'El correo es requerido.',
            'user.email.email' => 'El formato de correo es incorrecto.',
            'user.email.unique' => 'El correo ya existe.',
            'role.required' => 'El rol es requerido.',
            'user.password.required' => 'La contraseña es requerida.',
            'user.password.min' => 'La contraseña debe ser de al menos 6 caracteres.',
            'user.password.confirmed' => 'Las contraseñas no coinciden.',
            'employee.number.required' => 'El número de empleado es requerido.'
        ];
    }
}
