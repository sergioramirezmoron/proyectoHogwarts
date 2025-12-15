<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\UserRepository;

class UserTeachersProvider implements ProviderInterface
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        // 1. Obtenemos TODOS los usuarios de la base de datos
        $users = $this->userRepository->findAll();

        // 2. Filtramos con PHP puro.
        // Recorremos la lista y nos quedamos solo con los que tengan 'ROLE_TEACHER'
        $teachers = array_filter($users, function ($user) {
            return in_array('ROLE_TEACHER', $user->getRoles());
        });

        // Re-indexamos el array para que API Platform no se líe (opcional pero recomendado)
        return array_values($teachers);
    }
}