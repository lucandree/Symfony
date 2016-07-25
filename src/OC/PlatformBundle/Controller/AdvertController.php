<?php

// src/OC/PlatformBundle/Controller/AdvertController.php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Image;
use OC\PlatformBundle\Entity\Application;
use OC\PlatformBundle\Entity\Category;
use OC\PlatformBundle\Entity\Skill;
use OC\PlatformBundle\Entity\AdvertSkill;
use OC\PlatformBundle\Form\AdvertType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class AdvertController extends Controller
{
  public function indexAction($page)
  {
    if ($page < 1) {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    }

    // Ici je fixe le nombre d'annonces par pages à 3
    // Mais bien sur il faudrait utiliser un paramètre, et y accéder via $this->container->getParameter('nb_per_page')
    $nbPerPage = 3;

    // Pour récupérer la liste de toutes les annonces : on utilise findAll()
    $listAdverts = $this->getDoctrine()
      ->getManager()
      ->getRepository('OCPlatformBundle:Advert')
      ->getAdverts($page, $nbPerPage)
    ;

    $nbPages = ceil(count($listAdverts)/$nbPerPage);
  

    /*if ($page > $nbPages) {
      throw $this-> createNotFoundException("La page ".$page." n'existe pas.");
    }*/

    // L'appel de la vue ne change pas
    return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
      'listAdverts' => $listAdverts,
      'nbPages'     => $nbPages,
      'page'        => $page
    ));
  }

  /**
   * @ParamConverter("advert",      options={"mapping": {"advert_id": "id"})
   * @ParamConverter("application", options={"mapping": {"application_id": "id"})
   */
  public function viewAction(Advert $advert, Application $application)
  {
    // On récupère l'EntityManager
    $em = $this->getDoctrine()->getManager();

    // Pour récupérer une annonce unique : on utilise find()
    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

    // On vérifie que l'annonce avec cet id existe bien
    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    // Puis modifiez la ligne du render comme ceci, pour prendre en compte les variables :
    return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
      'advert'           => $advert
    ));
  }
  
  /**
   * @Security("has_role('ROLE_AUTEUR')")
   */
  public function addAction(Request $request)
  {
    /*// Création de l'entité Advert
    $advert1 = new Advert();
    $advert1->setTitle('Recherche développeur Symfony2.');
    $advert1->setAuthor('Alexandre');
    $advert1->setContent("Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…");

    // On peut ne pas définir ni la date ni la publication,
    // car ces attributs sont définis automatiquement dans le constructeur

    // On récupère l'EntityManager
    $em = $this->getDoctrine()->getManager();

    // Étape 1 : On « persiste » l'entité
    $em->persist($advert1);

    // Étape 2 : On « flush » tout ce qui a été persisté avant
    $em->flush();

    // On crée une nouvelle annonce
    $advert2 = new Advert();
    $advert2->setTitle('Mission de webmaster');
    $advert2->setAuthor('Hugo');
    $advert2->setContent('Nous recherchons un webmaster capable de maintenir notre site Internet.');

    // On récupère l'EntityManager
    $em = $this->getDoctrine()->getManager();

    // Étape 1 : On « persiste » l'entité
    $em->persist($advert2);

    // Étape 2 : On « flush » tout ce qui a été persisté avant
    $em->flush();

    // On crée une nouvelle annonce
    $advert3 = new Advert();
    $advert3->setTitle('Offre de stage webdesigner');
    $advert3->setAuthor('Mathieu');
    $advert3->setContent('Nous proposons un poste pour webdesigner.');

    // On récupère l'EntityManager
    $em = $this->getDoctrine()->getManager();

    // Étape 1 : On « persiste » l'entité
    $em->persist($advert3);

    // Étape 2 : On « flush » tout ce qui a été persisté avant
    $em->flush();

    // Reste de la méthode qu'on avait déjà écrit
    if ($request->isMethod('POST')) {
      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
      return $this->redirect($this->generateUrl('oc_platform_view', array('id' => $advert->getId())));
    }*/

    // On crée un objet Advert
    $advert = new Advert();

    // On crée le FormBuilder grâce au service form factory
    $form = $this->createForm(AdvertType::class, $advert);

    if ($form->handleRequest($request)->isValid()) {
      // C'est elle qui déplace l'image là où on veut les stocker
      $event= new MessagePostEvent($advert->getContent(),$advert->getUser());

      // On déclenche l'évènement
      $this->get('event_dispatcher')->dispatch(PlatformEvents::POST_MESSAGE, $event);

      $advert->setContent($event->getMessage());  

      $em = $this->getDoctrine()->getManager();
      $em->persist($advert);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

      return $this->redirect($this->generateUrl('oc_platform_view', array('id' => $advert->getId())));      
    }

    /*// On vérifie que l'utilisateur dispose bien du rôle ROLE_AUTEUR
    if (!$this->get('security.authorization_checker')->isGranted('ROLE_AUTEUR')) {
      // Sinon on déclenche une exception " Accès interdit "
      throw new AccessDeniedException('Accès limité aux auteurs.');      
    }*/
  
    return $this->render('OCPlatformBundle:Advert:add.html.twig', array(
      'form' => $form->createView(),
    ));
  }

  public function editAction($id)
  {
    // On récupère l'EntityManager
    $em = $this->getDoctrine()->getManager();

    // On récupère l'entité correspondant à l'id $id
    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

    // Si l'annonce n'existe pas, on affiche une erreur 404
    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    $form = $this->createForm(new AdvertEditType(), $advert);

    if ($form->handleRequest($request)->isValid()) {
      // Inutile de persister ici, Doctrine connait déjà notre annoce
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Annoce bien modifié.');

      return $this->redirect($this->generateUrl('oc_platform_view', array('id' => $advert->getId())));      
    }

    return $this->render('OCPlatformBundle:Advert:edit.html.twig', array(
      'form'   => $form->createView(),
      'advert' => $advert
    ));
  }

  public function deleteAction($id, Request $request)
  {
    // On récupère l'EntityManager
    $em = $this->getDoctrine()->getManager();

    // On récupère l'entité correspondant à l'id $id
    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

    // Si l'annonce n'existe pas, on affiche une erreur 404
    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    $form = $this->createFormBuilder()->getForm();

    if ($form->handleRequest($request)->isValid()) {
      $em->remove($advert);
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "L'annonce a bien été supprimée.");

      return $this->redirect($this->generateUrl('oc_platform_home'));
    }

    // Si la requête est en GET, on affiche une page de confirmation avant de delete
    return $this->render('OCPlatformBundle:Advert:delete.html.twig', array(
      'advert' => $advert,
      'form'   => $form->createView()
    ));
  }

  public function menuAction($limit = 3)
  {
    $listAdverts = $this->getDoctrine()
      ->getManager()
      ->getRepository('OCPlatformBundle:Advert')
      ->findBy(
        array(),                 // Pas de critère
        array('date' => 'desc'), // On trie par date décroissante
        $limit,                  // On sélectionne $limit annonces
        0                        // À partir du premier
    );

    return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
      'listAdverts' => $listAdverts
    ));
  }

  public function testAction()
  {
    $advert = new Advert;

    $advert->setDate(new \Datetime());
    $advert->setTitle('abc');
    //$avdert->setContent('blabla');
    $advert->setAuthor('A');

    // On récupère le service validator
    $validator = $this->get('validator');

    // On déclenche la validation sur notre object
    $listErrors = $validator->validate($advert);

    // Si le tableau n'est pas vide, on affiche les erreurs
    if(count($listErrors) > 0) {
      return new Response(print_r($listErrors, true));
    } else {
      return new Response("L'annonce est valide !");
    }
  }

  public function adminAction()
  {
    return new Response('<html><body>Admin page!</body></html>');
  }

  public function translationAction($name)
  {
    return $this->render('OCPlatformBundle:Advert:translation.html.twig', array(
      'name' => $name
    ));
  }

  /**
   * @ParamConverter("date", options={"format": "Y-m-d"})
   */
  public function viewListAction(\Datetime $date)
  { 
    
  }

  /**
   * @ParamConverter("json")
   */
  public function ParamConverterAction($json)
  {
    return new Response(print_r($json, true));
  }
}