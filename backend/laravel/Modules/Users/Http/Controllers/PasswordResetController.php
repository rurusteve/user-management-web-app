<?php

namespace Modules\Users\Http\v1\Controllers;

use Exception;
use App\Http\Controllers\ApiController;
use Modules\Users\Entities\User;
use Modules\Users\Entities\PasswordReset;
use Modules\Users\Http\v1\Requests\PasswordResetRequest;

class PasswordResetController extends ApiController
{
    public function send(PasswordResetRequest $request)
    {
        try {
            $user = User::findByEmail($request->email);
            $passReset = PasswordReset::sendPasswordReset($user->id);
        } catch (Exception $error) {
            // TODO: Use Exception handler
            return response($error, 500);
        }

        return $this->successResponse($passReset);
    }

    public function reset(PasswordResetRequest $request)
    {
        try {
            $passReset = PasswordReset::verifyPassword($request->toArray());
        } catch (Exception $error) {
            // TODO: Use Exception handler
            return response($error, 500);
        }

        return $this->successResponse($passReset);
    }
}
