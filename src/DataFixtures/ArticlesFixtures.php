<?php
 
namespace App\DataFixtures;

use App\Entity\User;

use App\Entity\Article;
use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\Tools\EntityGenerator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        // On desactive les logs SQL pour accélerer le processus
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);


        $articleTitles = [
            'quel régal!',
            'à mourrir d\'ennui',
            'meilleur jeu du siècle',
            'haletant et divertissant',
            'quelle production de la part des concepteurs du jeu',
            'une arnaque complète...',
        ];

        $articleMessages = [
            'EA Sports n\'a pas besoin de forcer puisque le jeu se vend à 20 millions d\'exemplaires tout les ans et s\'enrichi toute l\'année avec le mode FUT qui est un système à la limite de la loi ..
            De l\'autre côte nous avons PES qui possède un gameplay aux oignons mais qui manque de moyens pour s\'imposer en ligne... alors je sais pas les gens, si nous sommes 10 millions à acheter PES , Konami offrira un jeu plus puissant et ça forcera EA à se bouger le derche . C\'est d\'abord les consommateurs qui décident , regardez entre 2001 et 2009 Fifa se prenait une fessée et finalement ça a débouché sur un travail exemplaire et un fifa 10 absolument génial donc à nous de faire bouger les choses : achetez PES !',

            'Pourquoi vous séparez les joueurs en deux groupes selon leur sexe ? Les joueuses sont des joueurs. Le français est "inclusif", arrêtez de séparer.',

            'Ca fait super longtemps il me semble que ce jeu est en développement. Les combats ont l\'air bien foutu. Je suis pas ultra fan de l\'esthétique par contre.',

            'Ça fait longtemps qu\'on a pas eu de nouvelles de ce jeu, un DMC-like en monde ouvert avec des éléments RPG ça a l\'air excellent',

            'Il a l\'air monstrueux !',

            'Le jeu a part pomper tout ce qui existe deja Noctis + Devil may cry + Dark soul... 
            Encore un jeu chinois a boycotter durgence. 
            Coronavirus + esclavage des Ouighours on oublie pas bande de putins',
        ];

        $articleUser = [];
        $users =  $manager->getRepository(User::class)->findAll();

        foreach( $users as $user ){
            array_push($articleUser, $user);
        }


        $articleProduct = [];
        $products =  $manager->getRepository(Product::class)->findAll();
         
        foreach( $products as $product ){
            array_push($articleProduct, $product);
        }


        $articleRate = [
            2,
            5,
            4,
            1,
            5,
            3,
        ];





        for( $i = 0; $i< count($articleTitles); $i++) 
        {

            $article = new Article();
            $article->setTitle($articleTitles[$i]);
            $article->setMessage($articleMessages[$i]);
            $article->setUser($articleUser[$i]);
            $article->setCreatedAt(new \Datetime);
            $article->setRate($articleRate[$i]);
            $article->setProduct($articleProduct[$i]);


            // Le fait de conserver en référence nous permettra
            // d'utiliser cette entité dans d'autres fixtures
            $manager->persist($article);
        }
        $manager->flush();  
    }
}
