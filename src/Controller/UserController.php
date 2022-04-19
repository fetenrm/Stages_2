<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
class UserController extends AbstractController
{
    #[Route('/register', name: 'register', methods: 'POST')]
    public function create(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): Response
    {
        $entityManager  =$doctrine->getManager();
        $user = new User;
        
        $user->setEmail($request->get('email'));
        $user->setNom($request->get('nom'));
        $user->setPrenom($request->get('prenom'));
        $plainTextPassword = $request->get('password');
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plainTextPassword
        );
        $user->setPassword($hashedPassword);
        $user->setNumtel($request->get('num_tel'));
        $roles = [];
        array_push($roles,$request->get('roles'));
        $user->setRoles($roles);  // doit etre un array 
       $entityManager->persist($user);
        return $this->json(
            $user
         );
    }
}
