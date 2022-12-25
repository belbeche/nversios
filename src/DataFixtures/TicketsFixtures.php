<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Tickets;

class TicketsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i <= 10 ; $i++) { 
        	$ticket = new Tickets();
        	$ticket->setTitre("Titre de l'article n°$i")
        			->setContenu("<p>Contenu de l'article n°$i</p>")
        			->setImage("http://placehold.it/350x150")
        			->setCreatedAt(new \DateTime());
        	$manager->persist($ticket);
        }

        $manager->flush();
    }
}
