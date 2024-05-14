<?php

namespace App\Controller\Api;

use App\Entity\Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeController extends AbstractController
{
    /**
     * @Route("/api/types/{id}", name="app_api_findProductsByTypesById", methods={"GET"}, requirements={"id":"\d+"})
     * @Route("/api/types/{slug}", name="app_api_findProductsByTypesBySlug", methods={"GET"})
     */
    public function findProductsByTypes(Type $type): Response
    {        
        $products = $type->getProducts();
 
        /* Return the products linked to the Type called by is ID or SLUG in JSON*/
        return $this->json($products,Response::HTTP_OK,[],["groups" => "product"]);
    }
}