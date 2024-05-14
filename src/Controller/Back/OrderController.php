<?php

namespace App\Controller\Back;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/back/commandes", name="app_back_orders_list", methods={"GET"})
     */
    public function list(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAll();

        // Return all categories to the twig template
        return $this->render('back/order/list.html.twig', [
            'orders' => $orders,
        ]);
    }

    /**
     * @Route("/back/commandes/{id}", name="app_back_order_show", methods={"GET"})
     */
    public function show(Order $order): Response
    {
        // Return the product called by its ID
        return $this->render('back/order/show.html.twig', [
            'order' => $order,
        ]);
    }

    /**
     * @Route("/back/commandes/modifier/{id}", name="app_back_order_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Order $order, OrderRepository $orderRepository): Response 
    {
        // Creation of the prefilled form linked to the Order called by its ID
        $form = $this->createForm(OrderType::class, $order);

        // Links the submit request to the form
        $form->handleRequest($request);

        // Conditions for the object to be updated
        if ($form->isSubmitted() && $form->isValid()) {

            // Retreive the data filled in the update form
            $form->getData();
            
            // the "UpdatedAt" property is filled with the time & date of the update automatically
            $order->setUpdatedAt(new DateTimeImmutable());

            // the updated object is saved into the database
            $orderRepository->add($order, true);

            // Redirection to the list of orders after the update
            return $this->redirectToRoute('app_back_orders_list', [], Response::HTTP_SEE_OTHER);
        }

        // If the form is not valid, redirect to the update form of the object
        return $this->renderForm('back/order/edit.html.twig', [
            'order' => $order,
            'form' => $form,    
        ]);
        
    }
}
