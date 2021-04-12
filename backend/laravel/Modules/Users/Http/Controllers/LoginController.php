<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Users\Http\Requests\LoginRequest;
use App\Http\Controllers\ApiController;
use Exception;
use Modules\Users\Entities\User;

class LoginController extends ApiController
{
    /**
     * Performs Login action.
     * Allow login only when request is made by the approproate referer:
     *      - Tenant logs in from Public site
     *      - Landlord logs in from Public site
     *      - Admin logs in from Admin site
     *      - Agent logs in from Agent site
     *
     * @param LoginRequest $request
     * @return Token
     */
    public function login(LoginRequest $request)
    {
        $input = $request->all();
        try {
            $token = User::login($input);
        } catch (Exception $error) {
            return response($error, 403);
        }

        return response(['token' => $token->plainTextToken], 200);
    }
}
