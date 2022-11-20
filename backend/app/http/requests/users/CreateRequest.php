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
            'username' => ['required', 'string'],
            'email' => ['required', 'email'],
            'github' => ['required', 'url']
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'O Username é obrigatório',
            'username.string' => 'O Username deve ser uma string',
            'email.required' => 'O E-mail é obrigatório',
            'email.email' => 'O E-mail não é válido!',
            'github.required' => 'O Github é obrigatório',
            'github.url' => 'O Github deve ser uma url',
        ];
    }


}