<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/api/categories", name="app_api_categories", methods={"GET"})
     */
    public function getAllCategories(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        // Return all categories in json
        return $this->json($categories, Response::HTTP_OK, [],["groups" => "categories"] );
    }

    /**
     * @Route("/api/categories/{id}", name="app_api_productsByCategoryById", methods={"GET"}, requirements={"id":"\d+"})
     * @Route("/api/categories/{slug}", name="app_api_productsByCategoryBySlugname", methods={"GET"})
     */
    public function getAllProductsByCategory(Category $category, ProductRepository $productRepository): Response
    {
        if(!$category){
            // Return an error if the category not found
            return $this->json(["error" => "Category not found"], Response::HTTP_NOT_FOUND);
        }

        // we execute a custom query that returns the products of a category
        $products = $productRepository->getAllProductsByCategory($category);

        // we return all the products form the category in json
        return $this->json($products, Response::HTTP_OK, [], ["groups" => "productsByCategory"]);
    }

}
