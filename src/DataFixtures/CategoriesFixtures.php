<?php
 
namespace App\DataFixtures;

use App\Entity\Category;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // On desactive les logs SQL pour accélerer le processus
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        $categories = ['PS4', 'XBOX ONE', 'SWITCH', 'PC', 'PS5', 'XOBOX SERIES X'];
        foreach($categories as $name) 
        {
            $category = new Category();
            $category->setName($name);
            $category->setCreatedAt(new \Datetime);
            // Le fait de conserver en référence nous permettra
            // d'utiliser cette entité dans d'autres fixtures
            $this->addReference($name, $category);
            $manager->persist($category);
        }
        $manager->flush();  
    }
}
