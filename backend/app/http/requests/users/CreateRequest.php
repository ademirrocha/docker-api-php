<?php

namespace app\http\requests\users;

use app\vendor\http\validator\FormValidator;

class CreateRequest extends FormValidator
{

    public function __construct($parameters)
    {
        $this->parameters = (array) $parameters;
    }
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
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users|id'],
            'github' => ['required', 'url']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O Nome é obrigatório',
            'name.string' => 'O Nome deve ser uma string',
            'email.required' => 'O E-mail é obrigatório',
            'email.email' => 'O E-mail não é válido!',
            'email.unique:users|id' => 'Este E-mail já está em uso',
            'github.required' => 'O Github é obrigatório',
            'github.url' => 'O Github deve ser uma url',
        ];
    }


}