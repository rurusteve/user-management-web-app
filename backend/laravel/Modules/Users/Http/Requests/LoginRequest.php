<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Support\Facades\Config;
use Modules\Users\Entities\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    /**
     * Override validation fail handler,
     * to return response as json instead of redirect to another page
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'     => ['required', 'email:rfc'],
            'password'  => ['required', 'string', 'alpha_dash'],
        ];
    }

    /**
     * Checks whether the request referer matches the expected Subdomain
     *
     * @param string $subdomain [Subdomain of the Front-End application, as set in config]
     * @return bool
     */
    private function __checkRefererMatchesSubdomain(string $subdomain)
    {
        // Get the Referer domain
        $referer = explode('/', $this->header('Referer'))[2];
        // Check if Referer domain matches the acceptable domain
        if (in_array($referer, Config::get('authentication.subdomain.' . $subdomain))) {
            return true;
        }
        return false;
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
}
