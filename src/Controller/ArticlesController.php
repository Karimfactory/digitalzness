<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ArticlesController extends AbstractController
{
    /**
     * @Route("/articles-{$id}", name="article")
     */
    public function index(Request $request)
    {
        $request = Request::createFromGlobals();
        $id = $request->query->get('id');

        return $this->render('articles/index.html.twig', [
            'controller_name' => 'ArticlesController',
            'id' => $id
        ]);
    }


        /**
         * @Route("/all-posts", name="articles")
         */
        public function list(ArticleRepository $article)
        {
            $article->findAll();

            return $this->render('articles/allposts.html.twig', [
                'controller_name' => 'ArticlesController',
                'article' => $article,
            ]);
        }





}

   