<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{

    /**
     * @param EntityManagerInterface $em
     * @return mixed
     */
    #[Route('/users', name: 'user_list')]
    public function list(EntityManagerInterface $em): Response
    {
        return $this->render('user/list.html.twig', [
            'users' => $em->getRepository('App:User')->findAll()
        ]);
    }

    /**
     * @param User $user
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return mixed
     */
    #[Route('/users/{id}/edit', name: 'user_edit')]
    public function edit(User                        $user,
                               UserPasswordHasherInterface $userPasswordHasher,
                               EntityManagerInterface      $em,
                               Request                     $request
    )
    {
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}