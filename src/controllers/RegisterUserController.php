<?php

declare(strict_types=1);

namespace Src\controllers;

use Src\core\ErrorHandler;
use Src\models\User;

class RegisterUserController
{
    public function index(): array
    {
        echo "index register user controller";
        return [
            'view' => 'home',
            'data' => ['message' => 'Hello.'],
        ];
    }

    public function showUserProfile(int $userId): array  | ErrorHandler
    {
        $userModel = new User();
        $userData = $userModel->getUserById($userId);

        if ($userData) {
            return [
                'view' => 'profile',
                'data' => ['user' => $userData],
            ];
        } else {
            return [
                'view' => '404',
            ];
        }
    }

    public function showAllUsers(): array
    {
        $userModel = new User();

        if ($userModel->getAllUsers()) {
            $users = $userModel->getAllUsers();
            return [
                'view' => 'user_list',
                'data' => ['users' => $users],
            ];
        } else {
            return [
                'view' => 'errors/505',
            ];
        }

    }

    public function createUser(array $userData): array
    {
        $userModel = new User();

        // Validate input data here if needed

        if ($userModel->createUser($userData)) {
            return [
                'view' => 'success',
                'data' => ['message' => 'User created successfully'],
            ];
        } else {
            return [
                'view' => 'errors/505',
            ];
        }
    }

    public function updateUser(int $userId, array $userData): array
    {
        $userModel = new User();

        // Validate input data here if needed

        if ($userModel->updateUser($userId, $userData)) {
            return [
                'view' => 'success',
                'data' => ['message' => 'User updated successfully'],
            ];
        } else {
            return [
                'view' => 'errors/405',
            ];
        }
    }

    public function deleteUser(int $userId): array
    {
        $userModel = new User();

        if ($userModel->deleteUser($userId)) {
            return [
                'view' => 'success',
                'data' => ['message' => 'User deleted successfully'],
            ];
        } else {
            return [
                'view' => 'errors/405',
            ];
        }
    }

}
