<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\UserRepository;

class UserStudentsProvider implements ProviderInterface
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        // 1. Traemos todos los usuarios
        $users = $this->userRepository->findAll();

        // 2. Filtramos buscando 'ROLE_STUDENT'
        // (Asegúrate de que tus alumnos tengan este rol en la base de datos)
        $students = array_filter($users, function ($user) {
            return in_array('ROLE_STUDENT', $user->getRoles());
        });

        return array_values($students);
    }
}