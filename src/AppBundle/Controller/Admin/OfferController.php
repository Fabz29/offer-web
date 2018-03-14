<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Thematic;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\OfferType;
use AppBundle\Entity\Offer;
use AppBundle\Entity\Media;
use Symfony\Component\Form\FormError;

/**
 * @Route("/saSecureAlliance")
 */
class OfferController extends Controller
{
    /**
     *
     * @Route("/", name="app_admin_homepage")
     * @Route("/offers", name="app_admin_offer_list")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $offers = $em->getRepository('AppBundle:Offer')->findBy(array(), array('createdAt' => 'DESC'));

        return $this->render('Admin/Offer/list.html.twig', array(
            'offers' => $offers,
            'add_route' => 'app_admin_offer_edit'
        ));
    }

    /**
     *
     * @Route("/offer/edit/{offerId}", name="app_admin_offer_edit")
     */
    public function editAction(Request $request, $offerId = null)
    {
        $em = $this->getDoctrine()->getManager();

        if ($offerId != null) {
            $offer = $em->getRepository('AppBundle:Offer')->findOneById($offerId);

            if (!$offer) {
                $this->get('session')->getFlashBag()->add('error', "L'offre est introuvable !");

                return $this->redirectToRoute('app_admin_offer_list');
            }

        } else {
            $offer = new Offer();
            $defaultPicture = new Media();
            $defaultPicture->setPath('securalliance-fond.jpg');
            $offer->setBackground($defaultPicture);
        }



        $form = $this->createForm(OfferType::class, $offer, array('userIds' => $offer->getUsers()));

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->get('logo')->getData() == null && $offer->getLogo() == null){
            $this->get('session')->getFlashBag()->add('error', "Veuillez ajouter un logo.");
            $form->get('logo')->get('file')->addError(new FormError('Veuillez ajouter un logo.'));
        }

        if($form->isSubmitted() && $form->get('background')->getData() == null && $offer->getBackground() == null){
            $this->get('session')->getFlashBag()->add('error', "Veuillez une image de fond.");
            $form->get('background')->get('file')->addError(new FormError('Veuillez ajouter une image de fond.'));
        }

        $users = $em->getRepository('AppBundle:User')->findByOffer($offerId);

        if ($form->isSubmitted() && $form->isValid()) {

            $sharedThematics = $em->getRepository('AppBundle:Thematic')->findBy(array('isTemplate' => true, 'parentThematic' => null));

            foreach ($sharedThematics as $sharedThematic){
                $thematic = clone $sharedThematic;
                $thumbnail = clone $sharedThematic->getThumbnail();
                $thumbnail->setThematicThumbnail($thematic);
                $thematic->setOffer($offer);
                $em->persist($thumbnail);
                foreach ($sharedThematic->getSubThematics() as $subSharedThematic){
                    $subThematic = clone $subSharedThematic;
                    $thumbnail = clone $subSharedThematic->getThumbnail();
                    $subThematic->setParentThematic($thematic);
                    $subThematic->setOffer($offer);
                    $thumbnail->setThematicThumbnail($subThematic);
                    $em->persist($thumbnail);
                    foreach($subSharedThematic->getSlides() as $sharedSlide){
                        $slide = clone $sharedSlide;
                        $media = clone $sharedSlide->getMedia();
                        $media->setSlide($slide);
                        $slide->setThematic($subThematic);
                        $em->persist($media);
                        $em->persist($slide);
                    }
                }
            }

            foreach ($users as $user) {

                if (false === $offer->getUsers()->contains($user)) {
                    $user->setOffer(null);
                }
            }

            foreach ($form->get('users')->getData() as $user) {
                $user->setOffer($offer);
            }

            if($form->get('fileDownload')->getData()){
                $form->get('fileDownload')->getData()->setOfferDownload($offer);
            }
            
            $form->get('logo')->getData()->setOfferLogo($offer);
            $form->get('background')->getData()->setOfferBackground($offer);
            $em->persist($offer);

            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "L'offre a bien été modifiée.");

            return $this->redirectToRoute('app_admin_offer_edit', array('offerId' => $offer->getId()));

        }

        return $this->render('Admin/Offer/edit.html.twig', array(
            'offer' => $offer,
            'form' => $form->createView(),
            'add_route' => 'app_admin_offer_edit',
            'offerId' => $offerId,
        ));
    }

    /**
     *
     * @Route("/offer/remove/{offerId}", name="app_admin_offer_remove")
     */
    public function removeAction($offerId)
    {
        $em = $this->getDoctrine()->getManager();
        $offer = $em->getRepository('AppBundle:Offer')->findOneById($offerId);

        if (!$offer) {
            $this->get('session')->getFlashBag()->add('error', "L'offre est introuvable !");

            return $this->redirectToRoute('app_admin_offer_list');
        }

        $this->get('session')->getFlashBag()->add('success', "L'offre a bien été supprimée.");
        $em->remove($offer);
        $em->flush();

        return $this->redirectToRoute('app_admin_offer_list');

    }

    /**
     *
     * @Route("/offer/view/{offerId}", name="app_admin_offer_view")
     */
    public function viewAction($offerId)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $offer = $em->getRepository('AppBundle:Offer')->findOneById($offerId);

        if (!$offer) {
            $this->get('session')->getFlashBag()->add('error', "L'offre est introuvable !");

            return $this->redirectToRoute('app_admin_offer_list');
        }

        $parentThematics =  $em->getRepository('AppBundle:Thematic')->findBy(array('parentThematic' => null, 'offer' => $offer), array('suiteNumber' => 'ASC'));

        return $this->render('Frontend/Offer/view.html.twig', array(
            'offer' => $offer,
            'parentThematics' => $parentThematics,
        ));

    }
}