<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/api/produits", name="app_api_product_findAll", methods={"GET"})
     */
    public function findAll( ProductRepository $productRepository ): Response
    {
        $products = $productRepository->findAll();
 
        /* Return All the products in JSON*/
        return $this->json($products,Response::HTTP_OK,[],["groups" => "product"]);
    }

    /**
     * @Route("/api/produits/{id}", name="app_api_product_findOneById", methods={"GET"}, requirements={"id":"\d+"})
     * @Route("/api/produits/{slug}", name="app_api_product_findOneBySlugname", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        /* Return the product called by its ID or SLUG in JSON*/
        return $this->json($product,Response::HTTP_OK,[],["groups" => "product"]);
    }
}
