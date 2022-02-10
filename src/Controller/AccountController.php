<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
    public function __construct(ProductRepository $productRepository){
        $this->productRepository = $productRepository;
    }
    /**
     * @Route("/account", name="account")
     */
    public function index(): Response
    {
        $products = $this->productRepository->findALL();
        return $this->render('account/index.html.twig', [
            'products'=> $products    
        ]);
    }
}
