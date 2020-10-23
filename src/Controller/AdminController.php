<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\AddProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @Security("is_granted('ROLE_ADMIN')", 
     * statusCode=403, 
     * message="Vous n'avez pas les droits suffisant pour accéder à cette interface !")
     */
    public function index(Request $request)
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/addProduct", name="addProduct")
     */
    public function add(Request $request, EntityManagerInterface $manager)
    {
        $product = new Product();

        $form = $this->createForm(AddProductType::class, $product);
        $form->handleRequest($request);
        
        // prise en compte du formulaire
        if($form->isSubmitted() && $form->isValid()) {
            $product->setSlug($product->getName());
            $product->setCreatedAt(new \DateTime());

            $manager->persist($product); 
            $manager->flush(); 
            $this->addFlash('success', 'Article Created! Knowledge is power!');
            return $this->redirectToRoute('admin');

        }

        return $this->render('admin/add.html.twig', [
            'form' => $form->createView(),
            
        ]);
    }

     /**
     * @Route("/produits/edit/{slug}", name="product_edit")
     */
    public function edit(Product $product, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
 
        if($form->isSubmitted() && $form->isValid()) {
            $photo = $form->get('picture')->getData();
            if ($photo) {
                try {
                    $directory = $this->getParameter('products_picture_dir');
                    $name = uniqid('product-').'.'.$photo->guessExtension();
                    $photo->move($directory, $name);
                    // on supprime l'ancienne image si elle existe
                    if(!empty($oldFile) && file_exists($directory.'/'.$oldFile)) {
                        unlink($directory.'/'.$oldFile);
                    }
                    $product->setPicture('images/'.$name);                  
                } catch (FileException $e) { }
            }
            $product->setCreatedAt(new \Datetime());
            $manager->persist($product);
            $manager->flush();
 
            return $this->redirectToRoute('admin_product_list');
        }
 
        return $this->render('admin_product/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/produits/delete/{slug}", name="product_delete")
     */
    public function delete(Product $product, Request $request, EntityManagerInterface $manager):Response
    {
        if ($this->isCsrfTokenValid('product_delete', $request->query->get('token'))) {
            $manager->remove($product);
            $manager->flush();            
        }
   
        return $this->redirectToRoute('admin_product_list');
    }

}
