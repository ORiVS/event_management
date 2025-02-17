<?php

namespace App\EventManagement\Users;

class UserService {
    public function __construct(protected User $model) {

    }

    public function register(array $data) : User{
        $user = $this->model->fill($data);
        $user->save();
        return $user;
    }
}
