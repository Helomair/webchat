<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository {

    protected $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function createNewUser($data) {
        return $this->user->create($data);
    }

    public function getUser($id = null, $email = null) {
        try {
            if ($id !== null) {
                return $this->user->find($id);
            }

            if ($email !== null) {
                return $this->user->where('email', $email)->first();
            }

            throw new \Exception("One of userId and email should not be null");
        }
        catch (\Exception $e) {
            return "Caught error: " . $e->getMessage() . " In " . $e->getFile() . " At Line " . $e->getLine();
        }
        
    }
}