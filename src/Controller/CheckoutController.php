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
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CheckoutController extends AbstractController
{
    
    
    private $cartServices;
    private $session;
    public function __construct(CartServices $cartServices, ProductRepository $productRepository, SessionInterface $session){
    $this->cartServices = $cartServices;
    $this->productRepository = $productRepository;
    $this->session = $session;
    }
   

    
    /**
     * @Route("/checkout", name="checkout")
     */
    public function index(Request $request): Response
    {
        $products = $this->productRepository->findALL();
        $user = $this->getUser();
        $cart = $this->cartServices->getAllProductCart();

        if (!isset($cart['products'])) {
            return $this->redirectToRoute("home");
        }
        if (!$user->getAddresses()->getValues()) {
            $this->addFlash('checkout_message', 'Add an address before to proceed to ckeckout please');
            return $this->redirectToRoute("address_new");
            # code...
        }
        $form = $this->createForm(CheckoutType::class,null,['user'=>$user]);

        return $this->render('checkout/index.html.twig' , [
            'cart' => $cart,
            'products'=> $products,
            'checkout'=>$form->createView()  
        ]);
    }


    /**
     * @Route("/checkout/confirm", name="checkout_confirm")
     */
    public function confirm(Request $request): Response
    {
        $products = $this->productRepository->findALL();
        $user = $this->getUser();
        $cart = $this->cartServices->getAllProductCart();

        if (!isset($cart['products'])) {
            return $this->redirectToRoute("home");
        }
        if (!$user->getAddresses()->getValues()) {
            $this->addFlash('checkout_message', 'Add an address before to proceed to ckeckout please');
            return $this->redirectToRoute("address_new");
            # code...
        }
        $form = $this->createForm(CheckoutType::class,null,['user'=>$user]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() || $this->session->get('checkout_data')) {
            if ($this->session->get('checkout_data')) {
                $data = $this->session->get('checkout_data');
            }else{
                $data = $form->getData();
                $data = $form->getData();
                $this->session->set('checkout_data',$data);
            }
            
            
            $address = $data['address'];
            $carrier = $data['carrier'];
            $informations = $data['informations'];

            return $this->render('checkout/confirm.html.twig',[
                'cart' => $cart,
                'products'=> $products,
                'address' => $address,
                'carrier' => $carrier,
                'informations' => $informations,
                'checkout'=>$form->createView(),  

            ]);

        }
        return $this->redirectToRoute('checkout');

    }
}
