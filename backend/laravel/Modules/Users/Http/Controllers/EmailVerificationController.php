<?php

namespace Modules\Authentication\Http\v1\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Modules\Users\Entities\EmailVerification;

class EmailVerificationController extends ApiController
{
    public function send($id)
    {
        try {
            $ret = EmailVerification::sendEmailVerification($id);
        } catch (Exception $error) {
            return response($error, 403);
        }

        return $this->successResponse($ret);
    }

    public function verify(Request $request)
    {
        try {
            $verificationKey = $request->key;
            $ret = EmailVerification::verifyEmail($verificationKey);
        } catch (Exception $error) {
            // TODO: Use Exception handler
            return response($error, 500);
        }

        return $this->successResponse($ret);
    }
}
