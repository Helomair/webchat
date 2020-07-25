<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService {

    protected $user_repo;

    public function __construct(UserRepository $user_repo) {
        $this->user_repo = $user_repo;
    }

    public function createUser($name, $email, $password) {
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'api_token' => Str::random(60),
        ];

        return $this->user_repo->createNewUser($data);
    }

    public function userLoginCheck($email, $password) {
        $user = $this->user_repo->getUser(null, $email);
        
        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }
        else {
            return false;
        }
    }
}