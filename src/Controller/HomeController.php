<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tickets;
use App\Repository\TicketsRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\DemandeType;
use App\Entity\Themes;
use App\Entity\Utilisateur;
use App\Form\ContactType;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * */
    public function accueil(Request $request, \Swift_Mailer $mailer, EntityManagerInterface $manager)
    {

        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $attente = $this->getDoctrine()
            ->getRepository(Tickets::class)
            ->findAll();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($contact);
            $manager->flush();

            $contact = (new \Swift_Message('Nversios, Nouvelle demande'))
                ->setFrom('wbelbeche.s@gmail.com')
                ->setTo('wbelbeche.s@gmail.com')
                ->setBody(
                    $this->renderView(
                        // app/Resources/views/Emails/registration.html.twig
                        'tickets/inscription_email.html.twig',
                        ['sujet' => $contact],
                        ['email' => $contact],
                        ['contenu' => $contact],
                        ['nom' => $contact]
                    ),
                    'text/html'
                );

            $mailer->send($contact);

            return $this->redirectToRoute('home');
        }
        return $this->render('home/index.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }
    /**
     * @Route("/annonce", name="support")
     * */
    public function annonce(TicketsRepository $repo)
    {

        $tickets = $repo->findAll();
        return $this->render('home/support.html.twig', [
            'tickets' => $tickets
        ]);
    }

    /**
     * @Route("/annonce/nouvelle/{id}", name="tickets_nouveau")
     * @Route("/tickets/{id}/modifier", name="tickets_edit")
     * */
    public function create(Tickets $demande = null, Request $request, ObjectManager $manager, Utilisateur $users)
    {
        if (!$demande) {
            $demande = new Tickets();
        }
        // $demande = new Tickets();

        // $form = $this->createFormBuilder($demande)
        // 			 ->add('titre', TextType::class, [
        // 			 	'attr' => [
        // 			 		'placeholder' => "titre de la demande",
        // 			 		'class' => "form-control"
        // 			 	]
        // 			 ])
        // 			 ->add('contenu', TextareaType::class, [
        // 			 	'attr' => [
        // 			 		'placeholder' => "votre message",
        // 			 		'class' => "form-control"
        // 			 	]
        // 			 ])
        // 			 ->add('image', TextType::class)
        // 			 ->getForm();
        // 			 

        $form = $this->createForm(DemandeType::class, $demande);

        $theme = new Themes();
        $theme->addDemandeTheme($demande);
        $theme->setStatus('En attente');

        $demande->setUsersId($users);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!$demande->getId()) {
                $demande->setCreatedAt(new \DateTime());
            }
            $demande->setCreatedAt(new \Datetime());

            $manager->persist($demande);
            $manager->flush();

            return $this->redirectToRoute('security_connexion', ['id' => $demande->getId()]);
        }

        return $this->render('tickets/demandes.html.twig', [
            'formDemande' => $form->createView(),
            'demandeEdit' => $demande->getId() !== null
        ]);
    }

    /**
     * @Route("/tickets/{id}", name="tickets_show")
     * */
    public function show(Tickets $ticket)
    {

        // $ticket = $this->getDoctrine()
        //      ->getRepository(Tickets::class)
        //      ->find($id);

        // $form = $this->createForm(ReponseDemandeType::class, $reponse);

        return $this->render('tickets/show.html.twig', [
            'ticket' => $ticket
        ]);
    }
    /**
     * @Route("/assistance", name="assistance")
     * */
    public function contact()
    {
        return $this->render('home/assistance.html.twig');
    }
    /**
     * @Route("/utilisateur", name="users_membre")
     * */
    public function espaceMembre()
    {
        return $this->render('security/membre.html.twig');
    }
    /**
     * @Route("/suivre_demande/{id}", name="suivre_demande")
     * */
    public function addAction($id)
    {
        $tickets = $this->getDoctrine()
            ->getRepository(Tickets::class)
            ->find($id);

        return $this->render('tickets/suivreDemande.html.twig', [
            'tickets' => $tickets
        ]);
    }
}
