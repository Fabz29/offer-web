<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\StatsOffer;

class OfferController extends Controller
{
    /**
     * @Route("/", name="app_offer_view", )
     */
    public function homepageAction()
    {
        $em = $this->getDoctrine()->getManager();
        $offer = $this->getUser()->getOffer();

        if (!$offer and $this->getUser() != null and $this->getUser()->getUsername() == 'admin') {
            return $this->redirectToRoute('app_admin_homepage');
        } elseif (!$offer) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(404, "Offer not found");
        }

        $parentThematics = $em->getRepository('AppBundle:Thematic')->findBy(array('parentThematic' => null, 'offer' => $offer), array('suiteNumber' => 'ASC'));

        return $this->render("Frontend/Offer/view.html.twig", array(
            'offer' => $offer,
            'parentThematics' => $parentThematics,
        ));
    }
}