<?php

namespace App\EventManagement\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService {
    public function __construct(protected User $model) {

    }

    public function register(array $data) : User{
        $user = $this->model->fill($data);
        $user->save();
        return $user;
    }

    public function login(array $data) : User {
        // On cherche un utilisateur par email
        $user = $this->model->where('email', $data['email'])->first();

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if ($user && Hash::check($data['password'], $user->password)) {
            return $user; // Retourne l'utilisateur s'il est authentifié
        }

        throw new \Exception('Invalid credentials');
    }
}
