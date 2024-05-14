<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/back/utilisateurs", name="app_back_users_list", methods={"GET"})
     */
    public function list(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        // Return all users to the twig template
        return $this->render('back/user/list.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/back/utilisateurs/ajouter",name="app_back_user_add", methods={"GET", "POST"})
     */
    public function add(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Creation of a new User object
        $user = new User();
        
        // Creation of the form linked to the User entity with the properties described in the UserType
        $form = $this->createForm(UserType::class, $user);

        // Links the submit request to the form
        $form->handleRequest($request);

        // Conditions for the new object to be created
        if ($form->isSubmitted() && $form->isValid()) {

            // Retrieve the data filled in the creation form
            $form->getData();
            
            // the "CreatedAt" property is filled with the time & date of the creation automatically
            $user->setCreatedAt(new DateTimeImmutable());

            // hash the password (based on the security.yaml config for the $user class)
            // $user retrieves the corresponding hash logic in the security.yaml
            // suser->getPassword() retrieves the non-hashed password filled in the form
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );
            // Sets the hashed password
            $user->setPassword($hashedPassword);

            // the new object is added to the database
            $userRepository->add($user, true);

            // Redirection to the list of Users after the creation
            return $this->redirectToRoute('app_back_users_list', [], Response::HTTP_SEE_OTHER);
        }

        // If the form is not valid, redirect to the creation of a new object
        return $this->renderForm('back/user/add.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/back/utilisateurs/{id}", name="app_back_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        // Return the user called by its ID
        return $this->render('back/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/back/utilisateurs/modifier/{id}", name="app_back_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        // Creation of the prefilled form linked to the User called by its ID
        $form = $this->createForm(UserType::class, $user,["edit" => true]);

        // Links the submit request to the form
        $form->handleRequest($request);

        // Conditions for the object to be updated
        if ($form->isSubmitted() && $form->isValid()) {

            // Retreive the data filled in the update form
            $form->getData();

            // the "UpdatedAt" property is filled with the time & date of the update automatically
            $user->setUpdatedAt(new DateTimeImmutable());
            
            // the updated object is saved into the database
            $userRepository->add($user, true);

            // Redirection to the list of Users after the update
            return $this->redirectToRoute('app_back_users_list', [], Response::HTTP_SEE_OTHER);
        }

        // If the form is not valid, redirect to the update form of the object
        return $this->renderForm('back/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/back/utilisateurs/supprimer/{id}", name="app_back_user_delete", methods={"POST"})
     */
    public function delete(User $user, UserRepository $userRepository): Response
    {
        // Calls the method to delete the User called by its ID
        $userRepository->remove($user, true);

        // Redirection to the list of users
        return $this->redirectToRoute('app_back_users_list', [], Response::HTTP_SEE_OTHER);
    }
}
