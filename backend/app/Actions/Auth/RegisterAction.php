<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final class RegisterAction
{
    public $error = [];
    private $user;
    public function handle(array $request): mixed
    {
        try{
            \Log::info('Registering user', ['email' => $request['email']]);
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
            ]);
        }catch(\Exception $e){
            \Log::error('Register error', ['message' => $e->getMessage()]);
            $this->error = [
                'message' => $e->getMessage(),
                'code' => Response::HTTP_BAD_REQUEST
            ];
        }
        return $this->error;
    }
}

?>
