<?php

namespace App\Controller\Api;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\ProductOrder;
use App\Entity\User;
use App\Repository\OrderRepository;
use App\Repository\ProductOrderRepository;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/api/commandes/ajouter",name="app_api_order_add", methods={"POST"})
     */
    public function add(Request $request, OrderRepository $orderRepository, ProductOrderRepository $productOrderRepository, ManagerRegistry $manager): Response
    {
        // First we decode the json into an array
        $orderJson = json_decode($request->getContent(), true);

        // We create a new User object
        $order = new Order();

        // I set the user of the Order entity.
        // Since this is a relation to the User entity, I have to provide the whole entity, that we get via its id
        $order->setUser(
            $manager->getRepository(User::class)
            ->find(($orderJson["userId"]))
        );

        // the "CreatedAt" property is filled with the time & date of the creation automatically
        $order->setCreatedAt(new DateTimeImmutable());
        
        // We set the status
        $order->setStatus(1);

        // the new object is added to the database
        $orderRepository->add($order, true);

        // Then we get the Id of the inserted row for consistency for sending the data later
        $order->getId();

        // create an empty array to store the data sent in DB
        $dataToReturn = [];
        // Adding the order item added to DB
        $dataToReturn[] = $order;

        // we have an array of productOrders in the decoded Json, so we first select it
        $productOrders = $orderJson["productOrders"];

        // Since we might recieve several productOrders, we have to loop and add each productOrder separately
        foreach ($productOrders as $productOrder) {
            // We create a new ProductOrder
            $productOrderToAdd = new ProductOrder();
            
            // We set the required data
            $productOrderToAdd->setQuantity($productOrder["quantity"]);
            
            // Here, same logic than for the Order and the User entity relation
            $productOrderToAdd->setProduct(
                $manager->getRepository(Product::class)
                ->find(($productOrder["id"]))
        );
            // we don't have to use the above method to get the order, since we created it in this method and hence is avaiable
            $productOrderToAdd->setOrderCode($order);

            // We add the object to DB
            $productOrderRepository->add($productOrderToAdd, true);

            // Then we get the Id of the inserted row for consistency for sending the data later
            $productOrderToAdd->getId();

            // We add the productOrder to the dataToReturn array
            $dataToReturn[] = $productOrderToAdd;
        };

        // We return all the data that we added to the DB thanks to the dataToReturn array
        return $this->json($dataToReturn,Response::HTTP_OK, [], ["groups" => "returnedOrders"]);
    }

}
