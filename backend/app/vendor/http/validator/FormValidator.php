<?php

namespace app\vendor\http\validator;

class FormValidator
{

    protected $parameters;
    protected $responseMessages = [];
    protected $isValid = true;

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
            }
            else if($rule === 'email'){
                $isValid = EmailValidator::isValidate($attribute, $this->parameters);
            }
        }

        if(!$isValid){
            $this->isValid = false;
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