<?php

namespace Rodrigorioo\BackStrapLaravel\Http\Requests;

use Rodrigorioo\BackStrapLaravel\Models\Administrator;
use Illuminate\Foundation\Http\FormRequest;

class EditAdministratorRequest extends FormRequest
{

    protected $administrator;

    public function __construct(Administrator $administrator, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->administrator = $administrator;
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
            'name' => 'required',
            'email' => 'required|email|unique:administrators,email,'. $this->administrator->id .',id,deleted_at,NULL',
            'password' => 'nullable|confirmed',
            'role' => 'required',
        ];
    }
}
