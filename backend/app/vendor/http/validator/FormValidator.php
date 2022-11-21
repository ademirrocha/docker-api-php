<?php

namespace app\vendor\http\validator;


class FormValidator
{

    protected $parameters;
    protected $responseMessages = [];

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
        return [];
    }


    public function messages()
    {
        return [];
    }

    public function validator(){

        $rules = $this->rules();
        foreach ($rules as $field => $rule){
            if(is_array($rule)){
                foreach ($rule as $value){
                    $this->validate($field, $value);
                }
            } else {
                $this->validate($field, $rule);
            }
        }
        return $this->responseMessages;

    }


    public function validate($attribute, $rule)
    {
        $isValid = true;
        if($rule === 'required'){
            $isValid = RequiredValidator::isValidate($attribute, $this->parameters);
        } else if (isset($this->parameters[$attribute])){
            if($rule === 'url'){
                $isValid = UrlValidator::isValidate($attribute, $this->parameters);
            } else if($rule === 'string'){
                $isValid = StringValidator::isValidate($attribute, $this->parameters);
            } else if($rule === 'email'){
                $isValid = EmailValidator::isValidate($attribute, $this->parameters);
            } else if(count(explode('unique:', $rule)) > 1){
                $value = explode(':', $rule)[1];
                $options = explode('|', $value);
                $table = $options[0];
                $oldAttr = $options[1];
                $isValid = UniqueValidator::isValidate($attribute, $this->parameters, $table, $oldAttr);
            }
        }

        if(!$isValid){
            $this->addMessage($attribute, $rule);
        }

    }

    private function addMessage($attribute, $rule){
        if(isset($this->messages()[$attribute . '.' . $rule])){
            $this->responseMessages[] = [$attribute => $this->messages()[$attribute . '.' . $rule]];
        } else {
            $this->responseMessages[] = [$attribute => 'Valor inválido!'];
        }

    }

}