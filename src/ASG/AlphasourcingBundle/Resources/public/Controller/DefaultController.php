<?php
// src/ASG/AlphasourcingBundle/Controller/DefaultController.php

namespace ASG\AlphasourcingBundle\Controller;

use ASG\AlphasourcingBundle\Entity\Contact;
use ASG\AlphasourcingBundle\Entity\Partenaires;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($page)
    {        
      $content = $this->get('templating')->render('ASGAlphasourcingBundle:Default:index.html.twig');

      return new Response($content);
    }

    public function contactAction()
    {
    	$content = $this->get('templating')->render('ASGAlphasourcingBundle:Default:contact.html.twig');

    	return new Response($content);
    }

    public function viewAction()
    {
        $content = $this->get('templating')->render('ASGAlphasourcingBundle:Default:view.html.twig');

        return new Response($content);
    }

    public function addAction(Request $request)
    {
        /*// Création de l'entité Partenaires
        $partenaires = new Partenaires();
        $partenaires->setNom('Alcatel');
        $partenaires->setAdresse('55 avenue des Champs Pierreux, 92000 Nanterre');
        $partenaires->setEmail('');

        // Création de l'entité image
        $image = new Image();
        $image->setUrl('');
        $image->setAlt('alcatel');

        // On lie l'image à l'annonce
        $partenaires->setImage($image);

        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

        // Étape 1 : On « persiste » l'entité
        $em->persist($partenaires);

        // Étape 1 bis : si on n'avait pas défini le cascade={"persist"},
        // on devrait persister à la main l'entité $image
        // $em->persist($image);

        // Étape 2 : On déclenche l'enregistrement
        $em->flush();

        // Création de l'entité Partenaires
        $partenaires = new Partenaires();
        $partenaires->setNom('GE Energy');
        $partenaires->setAdresse('29 Boulevard de la Muette, 95140 Garges-lès-Gonesse');
        $partenaires->setEmail('');

        // Création de l'entité image
        $image = new Image();
        $image->setUrl('');
        $image->setAlt('ge energy');

        // On lie l'image à l'annonce
        $partenaires->setImage($image);

        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

        // Étape 1 : On « persiste » l'entité
        $em->persist($partenaires);

        // Étape 1 bis : si on n'avait pas défini le cascade={"persist"},
        // on devrait persister à la main l'entité $image
        // $em->persist($image);

        // Étape 2 : On déclenche l'enregistrement
        $em->flush();

        // Création de l'entité Partenaires
        $partenaires = new Partenaires();
        $partenaires->setNom('SFR');
        $partenaires->setAdresse('1 square Bela-Bartok, 75015 Paris');
        $partenaires->setEmail('');

        // Création de l'entité image
        $image = new Image();
        $image->setUrl('');
        $image->setAlt('sfr');

        // On lie l'image à l'annonce
        $partenaires->setImage($image);

        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

        // Étape 1 : On « persiste » l'entité
        $em->persist($partenaires);

        // Étape 1 bis : si on n'avait pas défini le cascade={"persist"},
        // on devrait persister à la main l'entité $image
        // $em->persist($image);

        // Étape 2 : On déclenche l'enregistrement
        $em->flush();

        // Création de l'entité Partenaires
        $partenaires = new Partenaires();
        $partenaires->setNom('Westinghouse');
        $partenaires->setAdresse('86 Rue de Paris, 91400 Orsay');
        $partenaires->setEmail('');

        // Création de l'entité image
        $image = new Image();
        $image->setUrl('');
        $image->setAlt('westinghouse');

        // On lie l'image à l'annonce
        $partenaires->setImage($image);

        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

        // Étape 1 : On « persiste » l'entité
        $em->persist($partenaires);

        // Étape 1 bis : si on n'avait pas défini le cascade={"persist"},
        // on devrait persister à la main l'entité $image
        // $em->persist($image);

        // Étape 2 : On déclenche l'enregistrement
        $em->flush();

        // Création de l'entité Partenaires
        $partenaires = new Partenaires();
        $partenaires->setNom('BNP Paribas');
        $partenaires->setAdresse('Paris');
        $partenaires->setEmail('');

        // Création de l'entité image
        $image = new Image();
        $image->setUrl('');
        $image->setAlt('bnp paribas');

        // On lie l'image à l'annonce
        $partenaires->setImage($image);

        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

        // Étape 1 : On « persiste » l'entité
        $em->persist($partenaires);

        // Étape 1 bis : si on n'avait pas défini le cascade={"persist"},
        // on devrait persister à la main l'entité $image
        // $em->persist($image);

        // Étape 2 : On déclenche l'enregistrement
        $em->flush();

        // Création de l'entité Partenaires
        $partenaires = new Partenaires();
        $partenaires->setNom('Technip');
        $partenaires->setAdresse('89 avenue de la Grande Armée, Paris 16');
        $partenaires->setEmail('');

        // Création de l'entité image
        $image = new Image();
        $image->setUrl('');
        $image->setAlt('technip');

        // On lie l'image à l'annonce
        $partenaires->setImage($image);

        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

        // Étape 1 : On « persiste » l'entité
        $em->persist($partenaires);

        // Étape 1 bis : si on n'avait pas défini le cascade={"persist"},
        // on devrait persister à la main l'entité $image
        // $em->persist($image);

        // Étape 2 : On déclenche l'enregistrement
        $em->flush();

        // Création de l'entité Partenaires
        $partenaires = new Partenaires();
        $partenaires->setNom('La Banque Postale');
        $partenaires->setAdresse('Paris');
        $partenaires->setEmail('');

        // Création de l'entité image
        $image = new Image();
        $image->setUrl('');
        $image->setAlt('banque postale');

        // On lie l'image à l'annonce
        $partenaires->setImage($image);

        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

        // Étape 1 : On « persiste » l'entité
        $em->persist($partenaires);

        // Étape 1 bis : si on n'avait pas défini le cascade={"persist"},
        // on devrait persister à la main l'entité $image
        // $em->persist($image);

        // Étape 2 : On déclenche l'enregistrement
        $em->flush();

        // Création de l'entité Partenaires
        $partenaires = new Partenaires();
        $partenaires->setNom('Cisco');
        $partenaires->setAdresse('');
        $partenaires->setEmail('');

        // Création de l'entité image
        $image = new Image();
        $image->setUrl('');
        $image->setAlt('cisco');

        // On lie l'image à l'annonce
        $partenaires->setImage($image);

        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

        // Étape 1 : On « persiste » l'entité
        $em->persist($partenaires);

        // Étape 1 bis : si on n'avait pas défini le cascade={"persist"},
        // on devrait persister à la main l'entité $image
        // $em->persist($image);

        // Étape 2 : On déclenche l'enregistrement
        $em->flush();

        // Création de l'entité Partenaires
        $partenaires = new Partenaires();
        $partenaires->setNom('Bouygues Telecom');
        $partenaires->setAdresse('');
        $partenaires->setEmail('');

        // Création de l'entité image
        $image = new Image();
        $image->setUrl('');
        $image->setAlt('bouygues');

        // On lie l'image à l'annonce
        $partenaires->setImage($image);

        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

        // Étape 1 : On « persiste » l'entité
        $em->persist($partenaires);

        // Étape 1 bis : si on n'avait pas défini le cascade={"persist"},
        // on devrait persister à la main l'entité $image
        // $em->persist($image);

        // Étape 2 : On déclenche l'enregistrement
        $em->flush();

        // L'objet Contact
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        if ($form->handleRequest($request)->isValid()) {
         // C'est elle qui déplace l'image là où on veut les stocker
         $event= new MessagePostEvent($advert->getContent(),$contact->getUser());


         $em = $this->getDoctrine()->getManager();
         $em->persist($contact);
         $em->flush();

                
         $request->getSession()->getFlashBag()->add('Message bien enregistré.');

         return $this->redirectToRoute('asg_alphasourcing_view', array('id' => $advert->getId()));
        }*/
    
        return $this->render('ASGAlphasourcingBundle:Default:add.html.twig', array(
         'form' => $form->createView(),
        ));
    } 

    public function partenairesAction()
    {
        $content = $this->get('templating')->render('ASGAlphasourcingBundle:Default:partenaires.html.twig');

        return new Response($content);
    }

    public function presentationAction()
    {
        $content = $this->get('templating')->render('ASGAlphasourcingBundle:Default:presentation.html.twig');

        return new Response($content);
    }
}
