<?php

namespace App\Controller\Api;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{
    /**
     * @Route("/api", name="app_api_home", methods={"GET"})
     */
    public function home(ProductRepository $productRepository): Response
    {
        // get random product data
        $products = $productRepository->findRandom();

        // Returns a random product data json
        return $this->json($products,Response::HTTP_OK,[],["groups" => "product"]);
    }

    /**
     * @Route("/search", name="app_main_search", methods={"GET"})
     */
    public function search(ProductRepository $productRepository, Request $request): Response
    {
        // get all products whose names are alike to the input in the searchbar
        $products = $productRepository->findAllOrderByNameSearch($request->get("search"));

        // return the collection of products found in JSON
        return $this->json($products,Response::HTTP_OK,[],["groups" => "product"]);
    }
}
