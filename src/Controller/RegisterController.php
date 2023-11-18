<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    public function index(UserPasswordHasherInterface $passwordHasher): Response
    {
        // Utwórz nowy obiekt użytkownika
        $user = new User();
        $user->setUsername('user1'); // Ustawienie nazwy użytkownika

        $plaintextPassword = 'user1'; // Hasło użytkownika
        $hashedPassword = $passwordHasher->hashPassword($user, $plaintextPassword);
        $user->setPassword($hashedPassword);

        $user->setRoles(['ROLE_USER']);

        return new Response('Nowy użytkownik został dodany!');
    }
}
