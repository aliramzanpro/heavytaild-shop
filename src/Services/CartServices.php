<?php

namespace App\Services;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartServices{
    private $session;
    private $productRepository;
    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    public function addToCart($id){
    
        $cart= $this->getCart();
        if (isset($cart[$id])) {
            //product in cart 
            $cart[$id]++;
        }else {
            //no product in cart 
            $cart[$id] = 1;
        }
        $this->updateCart($cart);
        
    }



    public function updateCart($cart){
        
        $this->session->set('cart',$cart);

    }


    public function getCart(){

        return $this->session->get('cart',[]);
    }


    public function removeFromCart($id){
        $cart= $this->getCart();

        if (isset($cart[$id])) {
            //product already in cart
            if ($cart[$id]>1) {
                //more than 1 same product
                $cart[$id]--;
            }else {
                unset($cart[$id]);
            }
            $this->updateCart($cart);
        }

    }


    public function removeAllFromCart($id){
        $cart= $this->getCart();

        if (isset($cart[$id])) {
            //product already in cart

                unset($cart[$id]);
                $this->updateCart($cart);
            }

    }



    public function deleteCart(){
        $this->updateCart([]);

    }

    public function getAllProductCart(){
        $cart = $this->getCart();
        $allProduct = [];
        foreach ($cart as $id => $quantity) {
            $product = $this->productRepository->find($id);

            if ($product) {
                $allProduct[]=
                [
                    "quantity" => $quantity,
                    "product" => $product
                ];
            } else {
                $this->removeFromCart($id);
            }
            
        }return $allProduct;
        
    }


}


