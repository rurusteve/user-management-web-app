<?php

namespace App\Http\Controllers\Traits;

trait ApiResponser{

    /**
     * Render an exception into an HTTP response.
     *@param mixed $data
     *@param mixed|null $message
     *@param int $code
     *@return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data = null, $message = null, $code = 200)
	{
		return response()->json([
			'message' => $message,
			'data' => $data
		], $code);
    }

    /**
     * Render an exception into an HTTP response.
     *@param mixed|null $message
     *@param int $code
     *@return \Illuminate\Http\JsonResponse
     */
	protected function errorResponse($message = null, $code)
	{
		return response()->json([
			'message' => $message,
			'data' => null
		], $code);
	}
}
