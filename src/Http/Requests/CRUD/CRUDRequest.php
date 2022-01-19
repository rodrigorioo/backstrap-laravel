<?php

namespace Rodrigorioo\BackStrapLaravel\Http\Requests\CRUD;

use Illuminate\Foundation\Http\FormRequest;

class CRUDRequest extends FormRequest
{

    protected $validation = [];

    public function __construct(array $validation = [], array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->validation = $validation;
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

        foreach($this->validation as $attributeName => $dataAttribute) {
            $rules[$attributeName] = $dataAttribute['rules'];
        }

        return $rules;
    }

    public function attributes() {

        $attributes = [];

        foreach($this->validation as $attributeName => $dataAttribute) {
            if(array_key_exists('attribute', $dataAttribute)) {
                $attributes[$attributeName] = $dataAttribute['attribute'];
            }
        }

        if(count($attributes) > 0) {
            return $attributes;
        }

        return parent::attributes();
    }

    public function messages() {

        $messages = [];

        foreach($this->validation as $attributeName => $dataAttribute) {
            if(array_key_exists('messages', $dataAttribute)) {
                foreach($dataAttribute['messages'] as $rule => $message) {
                    $messages[$attributeName.'.'.$rule] = $message;
                }
            }
        }

        if(count($messages) > 0) {
            return $messages;
        }

        return parent::messages();
    }

    protected function prepareForValidation() {

        foreach($this->validation as $attributeName => $dataAttribute) {

            if(isset($dataAttribute['prepare'])) {

                // Prepare attribute for validation
                if($this->{$attributeName} == '') {
                    $this->merge([$attributeName => $dataAttribute['prepare']['default_value']]);
                }
            }
        }

    }



}