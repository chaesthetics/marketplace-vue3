<?php

namespace App\Actions\Auth;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

final class RegisterAction
{
    public $error = [];
    private $user;
    public function handle(array $request): mixed
    {
        try{
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
            ]);

            $user->assignRole('user');
        }catch(\Exception $e){
            $this->error = [
                'message' => $e->getMessage(),
                'code' => Response::HTTP_BAD_REQUEST
            ];
        }
        return $this->error;
    }
}

?>
