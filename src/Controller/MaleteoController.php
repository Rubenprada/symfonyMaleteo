<?php

namespace App\Controller;

use App\Entity\Guardians;
use App\Form\FormDemoType;
use App\Form\GuardiansType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaleteoController extends AbstractController
{
    #[Route('/maleteo', name: 'homeView')]
    public function home(Request $request, EntityManagerInterface $doctrine)
    {   
        $formNewDemo = $this-> createForm(FormDemoType::class);
        $formNewDemo -> handleRequest($request);
        if ( $formNewDemo -> isSubmitted() && $formNewDemo -> isValid()) {
            $demo = $formNewDemo -> getData();
            $doctrine -> persist($demo);
            $doctrine -> flush();
        }
        $repositoryGuardians = $doctrine -> getRepository(Guardians :: class);
        $guardians = $repositoryGuardians -> findAll();
        return $this -> renderForm('maleteo/home.html.twig', [
            'guardians' => $guardians, 
            'formNewDemo'=>$formNewDemo
        ]);
    }
 
    #[Route('/maleteo/opiniones', name: 'insertGuardian')]
    public function newGuardianOpinion (Request $request, EntityManagerInterface $doctrine) {
        $formGuardian = $this-> createForm(GuardiansType::class);
        $formGuardian -> handleRequest($request);
        if ( $formGuardian -> isSubmitted() && $formGuardian -> isValid()) {
            $guardian = $formGuardian -> getData();
            $doctrine -> persist($guardian);
            $doctrine -> flush();
        }
        return $this->renderForm('maleteo/form.html.twig', [
            'guardiansForm' => $formGuardian
        ]);
    }
}
