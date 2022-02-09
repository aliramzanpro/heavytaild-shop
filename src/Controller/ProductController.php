<?php

namespace App\Controller;

use App\Entity\Product;
use App\Services\CartServices;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class ProductController extends AbstractController
{
    private $cartServices;
    public function __construct(CartServices $cartServices, ProductRepository $productRepository){
        $this->cartServices = $cartServices;
        $this->productRepository = $productRepository;
    }
    /**
     * @Route("/product/{slug}", name="product_details")
     */
    public function show(?Product $product, ProductRepository $productRepository ): Response
    {
        $products = $this->productRepository->findALL();
        
        if (!$product) {
            return $this->redirectToRoute('home');
        }
        return $this->render('product/single_product.html.twig', [
            'product' => $product,
            'products' => $products,
        ]);
    }

       


}
