<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CRUDRequest extends FormRequest
{

    protected array $validations = [];

    public function __construct(array $validations = [], array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->validations = $validations;

    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize () {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {

        $rules = [];

        foreach($this->validations as $fieldName => $validation) {
            $rules[$fieldName] = $validation->getRules();
        }

        return $rules;
    }

    public function attributes() {

        $attributes = [];

        foreach($this->validations as $fieldName => $validation) {

            $attribute = $validation->getAttribute();

            if($attribute !== '') {
                $attributes[$fieldName] = $attribute;
            }
        }

        if(count($attributes) > 0) {
            return $attributes;
        }

        return parent::attributes();
    }

    public function messages() {

        $messages = [];

        foreach($this->validations as $fieldName => $validation) {

            $messages = $validation->getMessages();

            if(count($messages)) {
                foreach($messages as $rule => $message) {
                    $messages[$fieldName.'.'.$rule] = $message;
                }
            }
        }

        if(count($messages) > 0) {
            return $messages;
        }

        return parent::messages();
    }

    protected function prepareForValidation() {

        foreach($this->validations as $fieldName => $validation) {

            $prepare = $validation->getPrepare();

            if(!is_null($prepare)) {

                // Prepare attribute for validation
                if($this->{$fieldName} == '') {
                    $this->merge([$fieldName => $prepare]);
                }
            }
        }

    }



}