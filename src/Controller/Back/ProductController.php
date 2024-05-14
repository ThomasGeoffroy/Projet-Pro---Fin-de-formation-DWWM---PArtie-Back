<?php

namespace App\Controller\Back;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/back/produits", name="app_back_products_list", methods={"GET"})
     */
    public function list(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        // Return all products to the twig template
        return $this->render('back/product/list.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/back/produits/ajouter", name="app_back_product_add", methods={"GET", "POST"})
     */
    public function add(Request $request, ProductRepository $productRepository): Response
    {
        // Creation of a new Product object
        $product = new Product();

        // Creation of the form linked to the Product entity with the properties described in the ProductType
        $form = $this->createForm(ProductType::class, $product);

        // Links the submit request to the form
        $form->handleRequest($request);
        
        // Conditions for the new object to be created
        if ($form->isSubmitted() && $form->isValid()) {

            // Retrieve the data filled in the creation form
            $form->getData();
            
            // the "CreatedAt" property is filled with the time & date of the creation automatically
            $product->setCreatedAt(new DateTimeImmutable());

            // the new object is added to the database
            $productRepository->add($product, true);

            // Redirection to the list of Products after the creation
            return $this->redirectToRoute('app_back_products_list', [], Response::HTTP_SEE_OTHER);
        }

        // If the form is not valid, redirect to the creation of a new object
        return $this->renderForm('back/product/add.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/back/produits/{id}", name="app_back_product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        // Return the product called by its ID
        return $this->render('back/product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/back/produits/modifier/{id}", name="app_back_product_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Product $product, ProductRepository $productRepository ): Response 
    {
        // Creation of the prefilled form linked to the Product called by its ID
        $form = $this->createForm(ProductType::class, $product);

        // Links the submit request to the form
        $form->handleRequest($request);

        // Conditions for the object to be updated
        if ($form->isSubmitted() && $form->isValid()) {

            // Retreive the data filled in the update form
            $form->getData();
            
            // the "UpdatedAt" property is filled with the time & date of the update automatically
            $product->setUpdatedAt(new DateTimeImmutable());

            // the updated object is saved into the database
            $productRepository->add($product, true);

            // Redirection to the list of Products after the update
            return $this->redirectToRoute('app_back_products_list', [], Response::HTTP_SEE_OTHER);
        }

        // If the form is not valid, redirect to the update form of the object
        return $this->renderForm('back/product/edit.html.twig', [
            'product' => $product,
            'form' => $form,    
        ]); 
    }

    /**
     * @Route("/back/produits/supprimer/{id}", name="app_back_product_delete", methods={"POST"})
    */
    public function delete(Product $product, ProductRepository $productRepository): Response
    {
        // Calls the method to delete the product called by its ID
        $productRepository->remove($product, true);
        
        // Redirection to the list of products
        return $this->redirectToRoute('app_back_products_list', [], Response::HTTP_SEE_OTHER);
    }
}
