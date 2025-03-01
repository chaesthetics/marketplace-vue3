<?php

namespace App\Actions\Auth;

// use App\Http\Middleware\ThrottleLoginRequests;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\Auth;

final class LoginAction
{
    // const MAX_ATTEMPT = 5;

    /**
     * @var RateLimiter
     */
    // private $limiter;

    /**
     * @var \App\Models\User
     */
    private $user;

    /**
     * get the login, passsword
     *
     * @var array
     */
    private $credentials;

    /**
     * get the login, passsword
     *
     * @var bool
     */
    private $remember;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = Auth::user();
        // $this->limiter = app(RateLimiter::class);
    }

    public function handle(LoginRequest $request)
    {
        $this->credentials = collect($request->validated())->only(['email', 'password'])->toArray();
        $this->remember = $request->boolean('remember', false);

        return $this;
    }

    public function attempt(): bool
    {
        $field = filter_var($this->credentials['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($field, $this->credentials['email'])->firstOrFail();

        if ($user) {
            $this->credentials['email'] = $user->email;
        } else {
            return false;
        }

        $authenticated = Auth::attempt($this->credentials, $this->remember);
        if ($authenticated) {
            $this->user = Auth::user();
        }

        return $authenticated;
    }

    public function getData(): array
    {
        if ($this->user !== null) {
            $name = config('app.name');
            $abilities = $this->user->getPermissionsViaRoles()->pluck('name');
            $token = $this->user->createToken($name, $abilities->toArray())->plainTextToken;

            return [
                'user' => [
                    ...$this->user->getAttributes(),
                    'role' => $this->user->roles[0]->name,
                ],
                'permissions' => $this->user->getPermissionsViaRoles()->pluck('name'),
                'token' => $token,
            ];
        }

        return [];
    }

//     public function attemptsLeft($request): int
//     {
//         $key = app(ThrottleLoginRequests::class)->resolveRequestSignature($request);

//         return $this->limiter->remaining($key, self::MAX_ATTEMPT);
//     }
}
