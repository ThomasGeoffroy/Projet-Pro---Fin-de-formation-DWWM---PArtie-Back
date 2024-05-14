<?php

namespace App\Controller\Back;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeController extends AbstractController
{
    /**
     * @Route("/back/types", name="app_back_types_list", methods={"GET"})
     */
    public function list(TypeRepository $typeRepository): Response
    {
        $types = $typeRepository->findAll();

         // Return all types to the twig template
        return $this->render('back/type/list.html.twig', [
            'types' => $types,
        ]);
    }

    /**
     * @Route("/back/types/ajouter",name="app_back_type_add", methods={"GET", "POST"})
     */
    public function add(Request $request, TypeRepository $typeRepository): Response
    {
        // Creation of a new Type object
        $type = new Type();

        // Creation of the form linked to the Type entity with the properties described in the TypeType
        $form = $this->createForm(TypeType::class, $type);

        // Links the submit request to the form
        $form->handleRequest($request);

        // Conditions for the new object to be created
        if ($form->isSubmitted() && $form->isValid()) {

            // Retrieve the data filled in the creation form
            $form->getData();

            // the "CreatedAt" property is filled with the time & date of the creation automatically
            $type->setCreatedAt(new DateTimeImmutable());

            // the new object is added to the database
            $typeRepository->add($type, true);

            // Redirection to the list of Types after the creation
            return $this->redirectToRoute('app_back_types_list', [], Response::HTTP_SEE_OTHER);
        }

        // If the form is not valid, redirect to the creation of a new object
        return $this->renderForm('back/type/add.html.twig', [
            'type' => $type,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/back/types/{id}", name="app_back_type_show", methods={"GET"})
     */
    public function show(Type $type): Response
    {
        // Return the type called by its ID
        return $this->render('back/type/show.html.twig', [
            'type' => $type,
        ]);
    }

    /**
     * @Route("/back/types/modifier/{id}", name="app_back_type_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Type $type, TypeRepository $typeRepository): Response
    {  
        // Creation of the prefilled form linked to the Type called by its ID
        $form = $this->createForm(TypeType::class, $type);

        // Links the submit request to the form
        $form->handleRequest($request);

        // Conditions for the object to be updated
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Retreive the data filled in the update form
            $form->getData();

            // the "UpdatedAt" property is filled with the time & date of the update automatically  
            $type->setUpdatedAt(new DateTimeImmutable());

            // the updated object is saved into the database
            $typeRepository->add($type, true);

            // Redirection to the list of Types after the update
            return $this->redirectToRoute('app_back_types_list', [], Response::HTTP_SEE_OTHER);
        }

        // If the form is not valid, redirect to the update form of the object
        return $this->renderForm('back/type/edit.html.twig', [
            'type' => $type,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/back/types/supprimer/{id}", name="app_back_type_delete", methods={"POST"})
     */
    public function delete(TypeRepository $typeRepository, Type $type): Response
    {
        // Calls the method to delete the Type called by its ID
        $typeRepository->remove($type, true);
    
        // Redirection to the list of types
        return $this->redirectToRoute('app_back_types_list', [], Response::HTTP_SEE_OTHER);
    }
}
