<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginFormRequest;
use App\Providers\RouteServiceProvider;

use App\Services\AuthService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $authService;
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->authService = new AuthService();
    }
    public function authenticate(LoginFormRequest $request){

        $validated = $request->validated();

        $response = $this->authService->authenticate($validated);
        if ($response["status"] === "error") {
            session()->flash("message", message($response["message"], "error"));
            return redirect()->back();
        }

//        $this->accessLogService->add(auth()->user(), [
//            "login_from" => "web",
//            "login_source" => "login"
//        ]);

        return redirect()->intended('/');
    }
}
