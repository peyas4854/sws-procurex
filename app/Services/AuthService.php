<?php

namespace App\Services;

use Auth;

class AuthService
{
    public function authenticate($data)
    {
        $remember = isset($data["remember"]) ? true : false;

        $attempt = Auth::attempt([$this->username() => $data["identity"], "password" => $data["password"]], $remember);
        if ($attempt === false) {
            Auth::logout();
            return [
                "status" => "error",
                "message" => "Invalid email or password.",
                "data" => []
            ];
        }

        $user = auth()->user();

        if ($user->active === 0) {
            Auth::logout();
            return [
                "status" => "error",
                "message" => "User is not active",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "message" => "",
            "data" => []
        ];
    }

    protected function username()
    {
        $login = request()->input('identity');

        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$field => $login]);

        return $field;
    }
}
