<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class AddProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'Nom du produit:   '])
            ->add('description', null, ['label' => 'Description :   '])
            ->add('picture', FileType::class, [
                'label' => 'Image :   ',
                'constraints' => [
                    new File([
                    'maxSize' => '2048k',
                    'mimeTypes' => [
                        'image/*',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid document',
                ])]
            ])
            ->add('price', null, ['label' => 'Prix :   '])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'multiple' => true, 
                'expanded' => true, 
                'choice_label' => 'name' 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
