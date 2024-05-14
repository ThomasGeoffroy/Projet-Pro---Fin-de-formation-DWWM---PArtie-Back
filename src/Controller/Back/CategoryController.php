<?php

namespace App\Controller\Back;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/back/categories", name="app_back_categories_list", methods={"GET"})
     */
    public function list(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        // Return all categories to the twig template
        return $this->render('back/category/list.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/back/categories/ajouter",name="app_back_category_add", methods={"GET", "POST"})
     */
    public function add(Request $request, CategoryRepository $categoryRepository): Response
    {
        // Creation of a new Category object
        $category = new Category();

        // Creation of the form linked to the Category entity with the properties described in the CategoryType
        $form = $this->createForm(CategoryType::class, $category);

        // Links the submit request to the form
        $form->handleRequest($request);

        // Conditions for the new object to be created
        if ($form->isSubmitted() && $form->isValid()) {

            // Retrieve the data filled in the creation form
            $form->getData();
            
            // the "CreatedAt" property is filled with the time & date of the creation automatically
            $category->setCreatedAt(new DateTimeImmutable());
            
            // the new object is added to the database
            $categoryRepository->add($category, true);

            // Redirection to the list of Categories after the creation
            return $this->redirectToRoute('app_back_categories_list', [], Response::HTTP_SEE_OTHER);
        }

        // If the form is not valid, redirect to the creation of a new object
        return $this->renderForm('back/category/add.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/back/categories/{id}", name="app_back_category_show", methods={"GET"})
     */
    public function show(Category $category): Response
    {  
        // Return the category called by its ID
        return $this->render('back/category/show.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/back/categories/modifier/{id}", name="app_back_category_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        // Creation of the prefilled form linked to the Category called by its ID
        $form = $this->createForm(CategoryType::class, $category);

        // Links the submit request to the form
        $form->handleRequest($request);

        // Conditions for the object to be updated 
        if ($form->isSubmitted() && $form->isValid()) {

            // Retreive the data filled in the update form
            $form->getData();

            // the "UpdatedAt" property is filled with the time & date of the update automatically
            $category->setUpdatedAt(new DateTimeImmutable());
            
            // the updated object is saved into the database
            $categoryRepository->add($category, true);

            // Redirection to the list of Categories after the update
            return $this->redirectToRoute('app_back_categories_list', [], Response::HTTP_SEE_OTHER);
        }

        // If the form is not valid, redirect to the update form of the object
        return $this->renderForm('back/category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/back/categories/supprimer/{id}", name="app_back_category_delete", methods={"POST"})
     */
    public function delete(CategoryRepository $categoryRepository, Category $category): Response
    {
        // Calls the method to delete the Category called by its ID
        $categoryRepository->remove($category, true);
    
        // Redirection to the list of categories
        return $this->redirectToRoute('app_back_categories_list', [], Response::HTTP_SEE_OTHER);
    }
}