<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

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
       $entityManager->flush();
        return $this->json(
            $user
         );
    }
    #[Route('/admin/users', name: 'users_list', methods: 'GET')]
    public function index(ManagerRegistry $doctrine)
    {
        $repository = $doctrine->getRepository(User::class);
        $data = $repository->findAll();
        return  $this->json($data);
    }
    #[Route('/admin/users/{id}', name: 'user_delete', methods: 'DELETE')]
    public function delete(string $id,ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        $entityManager->remove($user);
        $entityManager->flush();
        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;
        }
    #[Route('/admin/user/info', name: 'user_info', methods: 'PoST')]
    public function show(Request $request, JWTEncoderInterface $jwtEncoder)
    {
        $token = $request->get('token');
       $data =  $jwtEncoder->decode($token);
       return new JsonResponse($data);
    }
}
