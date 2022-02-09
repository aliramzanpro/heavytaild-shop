<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Services\CartServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartController extends AbstractController
{
    private $cartServices;
    public function __construct(CartServices $cartServices, ProductRepository $productRepository){
    $this->cartServices = $cartServices;
    $this->productRepository = $productRepository;
    }

    /**
     * @Route("/cart", name="cart")
     */
    public function index(): Response
    {
        $cart = $this->cartServices->getAllProductCart();

        if (!isset($cart['products'])) {
            return $this->redirectToRoute("home");
        }
        $products = $this->productRepository->findALL();
        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'products'=>$products    
        ]);
    }

    /**
     * @Route("/cart/addtocart/{id}", name="addtocart")
     */
    public function addToCart($id): Response
    {
        $this->cartServices->addToCart($id);
        return $this->redirectToRoute("cart");
    }

    /**
     * @Route("/cart/removefromcart/{id}", name="removefromcart")
     */
    public function removeFromCart($id):Response
    {
       
        $this->cartServices->removeFromCart($id);
        return $this->redirectToRoute("cart");
        
    }

    /**
     * @Route("/cart/removeallfromcart/{id}", name="removeallfromcart")
     */
    public function removeAllFromCart($id):Response
    {
       
        $this->cartServices->removeAllFromCart($id);
        return $this->redirectToRoute("cart");
        
    }
}
