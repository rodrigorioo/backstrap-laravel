<?php

namespace Rodrigorioo\BackStrapLaravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Rodrigorioo\BackStrapLaravel\Facades\BackStrapLaravel;

class ResetPasswordRequest extends FormRequest
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
            'token' => 'required|string|exists:password_resets,token',
        ];
    }

    protected function getRedirectUrl()
    {
        return url(BackStrapLaravel::getLoginConfiguration()['full_forgot_password_url']);
    }
}
