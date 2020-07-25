<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    protected $user_service;

    public function __construct(UserService $user_service) {
        $this->user_service = $user_service;
    }

    public function register(Request $request) {
        Validator::make(
            $request->all(), 
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6']
            ],
        )->validate();

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        return $this->user_service->createUser($name, $email, $password);
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = $this->user_service->userLoginCheck($email, $password);

        $result = [
            'user' => $user,
            'sucess' => true,
        ];

        if ($user === false) {
            $result['sucess'] = false;
        }

        return response()->json($result);
    }
}
