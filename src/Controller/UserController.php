<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
     /**
     * @Route("/inscription", name="register_user")
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
        // prise en compte du formulaire
        if($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $user->setCreatedAt(new \DateTime());

            $manager->persist($user); 
            $manager->flush(); 
            $this->addFlash('success', 'Le compte utilisateur a bien été créé !');

            //envoi du mail de confirmation
            mail($user->getEmail(), 
                'Bienvenue chez ServiceTechnique!',
                'vous faite maintenant partie des abonnés a notre service technique informatique, veuillez valider votre adresse email en cliquant sur ce lien',
            );

            return $this->redirectToRoute('home');

        }

        return $this->render('user/index.html.twig', [
            'form' => $form->createView(),
            
        ]);
    }

}
