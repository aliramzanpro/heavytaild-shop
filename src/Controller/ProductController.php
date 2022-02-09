<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use App\Services\CartServices;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class ProductController extends AbstractController
{
    private $session;
    private $productRepository;
    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/product/{slug}", name="product_details")
     */
    public function show(?Product $product): Response
    {
        if (!$product) {
            return $this->redirectToRoute('home');
        }
        return $this->render('product/single_product.html.twig', [
            'product' => $product,
        ]);
    }

       


}
