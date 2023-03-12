<?php

namespace App\Controller;

use App\Form\LoginType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/create/user', name: 'createUser')]
    public function insertUser(Request $request, EntityManagerInterface $doctrine, UserPasswordHasherInterface $hasher) {
        $form = $this-> createForm(LoginType::class);
        $form-> handleRequest($request);
        if ($form-> isSubmitted() && $form-> isValid()) {
            $user = $form-> getData();
            $password = $user -> getPassword();
            $cifrado = $hasher-> hashPassword($user, $password);
            $user -> setPassword($cifrado);
            $doctrine-> persist($user);
            $doctrine-> flush();
            $this-> addFlash('success', 'Usuario insertado correctamente');
            return $this-> redirectToRoute('homeView');
        }
        return $this-> renderForm('login/createUser.html.twig', [
            'userForm'=> $form
        ]);
    } 


    
}
