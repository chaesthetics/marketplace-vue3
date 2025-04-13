<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Auth\LoginAction;
use App\Http\Requests\LoginRequest;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request, LoginAction $action)
    {   
        $login = $action->handle($request);

        if (!$login->attempt($request)) {
            return response()->json([
                'message' => 'Invalid credentials provided',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json($login->getData(), Response::HTTP_OK);
    }
}