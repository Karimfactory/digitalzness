<?php

namespace App\DataFixtures;

use App\Entity\Product;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // On desactive les logs pour accélerer le processus
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        $productsByCateg = [
            'PS4' => [
                [
                    'name'        => "Marvel's Iron Man Vr PS4",
                    'description' => "Enfilez votre casque PlayStation VR, mettez l'armure du légendaire super-héros de Marvel et sauvez le monde ! Des combats spectaculaires vous attendent contre les pires ennemis d'Iron Man. Activez les répulseurs à réaction d'Iron Man à l'aide de vos deux manettes de détection de mouvements PlayStation Move, envolez-vous et utilisez l'arsenal high-tech d'Iron Man. Et si vous avez besoin d'améliorations, rendez-vous au garage de Tony Stark pour personnaliser la fabuleuse armure d'Iron Man et ses capacités surhumaines.",
                    'picture'     => 'images/102465.jpg',
                    'price'        => 34.99
                ],   
                [
                    'name'          => 'The Last Of Us Part II',
                    'description'   => "Faites face aux terribles répercutions physiques et émotionnelles des actions d'Ellie !!! Cinq ans après leur voyage périlleux à travers une Amérique ravagée par une pandémie, Ellie et Joel ont trouvé refuge à Jackson, dans le Wyoming. Vivre dans une communauté florissante de survivants leur a permis de connaître la paix et la stabilité en dépit de la menace constante des infectés et des survivants désespérés.",
                    'picture'     => 'images/102294.jpg',
                    'price'         => 69.99
                ]
            ],
            'XBOX ONE' => [
                [
                    'name'        => "Apex Legends",
                    'description' => "Aux confins de l’espace connu se déroulent les Jeux Apex, une compétition de Battle Royale où des hors-la-loi et des marginaux combattent pour décrocher le titre de Champion. Triomphez pour devenir une Légende",
                    'picture'     => 'images/101731.jpg',
                    'price'         => 14.99
                ],   
                [
                    'name'          => 'F1 2020',
                    'description'   => "F1® 2020 est le jeu de F1® le plus complet à ce jour, plaçant les joueurs dans le cockpit pour affronter les meilleurs pilotes mondiaux.",
                    'picture'     => 'images/104993.jpg',
                    'price'         => 69.99
                ],   
                [
                    'name'          => 'Doom Eternal',
                    'description'   => "Développé par id Software, DOOM® Eternal™ est la suite directe du jeu DOOM®, élu Best Action Game aux Game Awards de 2016.",
                    'picture'     => 'images/88743.jpg',
                    'price'         => 44.99
                ]
            ],
            'SWITCH' => [
                [
                    'name'        => "Paper mario the origami king",
                    'description' => "Le Royaume Champignon est tout chiffonné : un Roi Origami maléfique a transformé de nombreux éléments du décor 2D en... origamis 3D.",
                    'picture'     => 'images/105214.jpg',
                    'price'        => 59.99
                ],   
                [
                    'name'          => 'FIFA 20',
                    'description'   => "EA SPORTS™ FIFA 20 Édition Essentielle sortira le 27 septembre sur Nintendo Switch™ avec les maillots et les effectifs à jour des clubs des plus grands championnats.",
                    'picture'     => 'images/98920.jpg',
                    'price'         => 19.99
                ]
            ]
        ];


        foreach($productsByCateg as $category => $products) 
        {
            foreach($products as $info) {
                $product = new Product();
                $product->setName($info['name']);
                $product->setDescription($info['description']);
                $product->setPicture($info['picture']);
                $product->setPrice($info['price']);
                $product->addCategory($this->getReference($category));
                $product->setCreatedAt(new \Datetime);
                $manager->persist($product);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // ici on peut lister les fixtures nécessaires avant 
        // d'exécuter cette fixture (Product)
        return array(
            CategoriesFixtures::class,
        );
    }
}