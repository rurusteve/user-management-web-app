<?php

namespace Modules\Users\Http\Controllers;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Users\Entities\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PropertyRequest $request  [Request after passing data validation filter]
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            $params = $request->all();
            $user   = User::list($params);
        } catch (Exception $error) {
            // TODO: Use Exception handler
            return response($error, 500);
        }
        return response($user, 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        try {
            $params = $request->all();
            $user   = User::create($params);
        } catch (Exception $error) {
            // TODO: Use Exception handler
            return response($error, 500);
        }
        return response($user, 200);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        try {
            $user   = User::find($id);
        } catch (Exception $error) {
            // TODO: Use Exception handler
            return response($error, 500);
        }
        return response($user, 200);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        try {
            $params = $request->all();
            $user   = User::find($id);
            $user -> update($params);
        } catch (Exception $error) {
            // TODO: Use Exception handler
            return response($error, 500);
        }
        return response($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try {
            $user   = User::destroy($id);
        } catch (Exception $error) {
            // TODO: Use Exception handler
            return response($error, 500);
        }
        return response($user, 200);
    }
}
