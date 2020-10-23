<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductPageController extends AbstractController
{
    /**
     * @Route("/produit-{name}", name="product_page")
     */
    public function index(Product $product)
    {
        $article = $product->getArticles();
        return $this->render('product_page/index.html.twig', [
            'product' => $product,
            'article' => $article          
        ]);
    }


}

