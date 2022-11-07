<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/user', name: 'index.user')]
    public function index(): Response
    {
        $user =$this->getUser();
        return $this->render('user/index.html.twig', [
            'controller_name'   => 'UserController',
            'mainNavUser'       => true,
            'user'              => $user
        ]);
    }

    #[Route('user/modifier/info', name: 'edit.user')]
    public function edit(Request $request):Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('succes', 'Vos Information Ont Bien été Modifier');
            return $this->redirectToRoute("index.user");
        }

        return  $this->render('user/edit.html.twig', [
            'user'          => $user,
            'form'          => $form->createView(),
        ]);
    }
}
