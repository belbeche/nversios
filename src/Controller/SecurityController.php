<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_inscription")
     * */
    public function Inscription(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, UtilisateurRepository $users)
    {
        $users = new Utilisateur();

        $form = $this->createForm(RegistrationType::class, $users);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($users, $users->getPassword());

            $users->setPassword($hash);

            $manager->persist($users);

            $manager->flush();

            return $this->redirectToRoute('tickets_nouveau', ['id' => $users->getId()]);
        }

        return $this->render('security/registration.html.twig', [
            'formInscription' => $form->createView(),
        ]);
    }
    /**
     * @Route("/connexion", name="security_connexion")
     * */
    public function connexion()
    {
        return $this->render('security/membre.html.twig', []);
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     * */
    public function deconnexion()
    {
    }
}
