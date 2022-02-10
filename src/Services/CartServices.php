<?php

namespace App\Services;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartServices{
    private $session;
    private $productRepository;
    private $tva = 0.2;

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
        
        $this->session->set('cartData', $this->getAllProductCart());

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
        $quantity_cart = 0; 
        $subTotal = 0;
        

        foreach ($cart as $id => $quantity) {
            $product = $this->productRepository->find($id);

            if ($product) {
                $allProduct["products"][]=
                [
                    "quantity" => $quantity,
                    "product" => $product
                ];
                $quantity_cart += $quantity;
                $subTotal += $quantity * ($product->getPrice()/100);
            } else {
                $this->removeFromCart($id);
            }
            $allProduct['data']= [
                "quantity_cart" => $quantity_cart,
                "subTotalHT"=>round($quantity * ($product->getPrice()*(1-$this->tva)/100),2),
                "taxe"=> round($subTotal*($this->tva),2),
                "subTotalTTC" => round($subTotal,2),

            ];
            
        }return $allProduct;
        
    }


}


