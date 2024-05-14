<?php

namespace App\Controller\Back;

use App\Entity\Category;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Type;
use App\Entity\User;
use App\Service\CallUserApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_back_index", methods="GET")
     */
    public function index (): Response
    {
        return $this->redirectToRoute('app_back_main_index');
    }

    /**
     * @Route("/back", name="app_back_main_index", methods="GET")
     */
    public function backOffice(CallUserApiService $callUserApiService, EntityManagerInterface $entityManager): Response
    {
        // Methods for each entity that select the firest 5 entries to display on the main BackOffice page
        $products = $entityManager->getRepository(Product::class)->productsMainBackOffice();
        $categories = $entityManager->getRepository(Category::class)->categoriesMainBackOffice();
        $types = $entityManager->getRepository(Type::class)->typesMainBackOffice();
        $users = $entityManager->getRepository(User::class)->usersMainBackOffice();
        $orders = $entityManager->getRepository(Order::class)->ordersMainBackOffice();
        
        // Return all the entities to the twig template
        return $this->render('back/main/index.html.twig', [
            'products' => $products,
            'categories' => $categories,
            'types' => $types,
            'users' => $users,
            'orders' => $orders,
        ]);
    }
}
