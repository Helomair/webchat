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
        $input = $request->all();
        Validator::make(
            $input, 
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6']
            ],
        )->validate();

        return $this->user_service->createUser($input['name'], $input['email'], $input['password']);
    }
}
