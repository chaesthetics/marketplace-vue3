<?php 
namespace  App\Http\Controllers\Api\Auth;

use App\Actions\Auth\RegisterAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request, RegisterAction $registerAction)
    {
        \Log::info('RegisterController is being hit!');

        $register = $registerAction->handle($request->validated());

        if (!empty($register)) {
            \Log::error('Register error', $register->error);
            return response()->json($register->error);
        }

        return response()->json([
            'message' => 'User registered successfully',
        ], Response::HTTP_CREATED);
    }
}
?>