<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CheckoutType;
use App\Services\CartServices;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckoutController extends AbstractController
{
    
    public function __construct(ProductRepository $productRepository){
    $this->productRepository = $productRepository;
    }
   

    
    /**
     * @Route("/checkout", name="checkout")
     */
    public function index(CartServices $cartServices, Request $request): Response
    {
        $products = $this->productRepository->findALL();
        $user = $this->getUser();
        $cart = $cartServices->getAllProductCart();

        if (!$cart) {
            return $this->redirectToRoute("home");
        }
        if (!$user->getAddresses()->getValues()) {
            $this->addFlash('checkout_message', 'Add an address before to proceed to ckeckout please');
            return $this->redirectToRoute("address_new");
            # code...
        }
        $form = $this->createForm(CheckoutType::class,null,['user'=>$user]);
        $form->handleRequest($request);

        //traitement du formulaire

        return $this->render('checkout/index.html.twig' , [
            'cart' => $cart,
            'products'=> $products,
            'checkout'=>$form->createView()  
        ]);
    }
}
