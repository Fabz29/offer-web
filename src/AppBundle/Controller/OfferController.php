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
        $user = $this->getUser();

        if (!$offer and $this->getUser() != null and $this->getUser()->getUsername() == 'admin') {
            return $this->redirectToRoute('app_admin_homepage');
        } elseif (!$offer or $user->getAccessEndAt() < new \DateTime()) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(404, "Aucune offre disponible !");
        }

        $parentThematics = $em->getRepository('AppBundle:Thematic')->findBy(array('parentThematic' => null, 'offer' => $offer), array('suiteNumber' => 'ASC'));

        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $mobile_agents = '!(tablet|pad|mobile|phone|symbian|android|ipod|ios|blackberry|webos)!i';
            if (preg_match($mobile_agents, $_SERVER['HTTP_USER_AGENT'])) {
                $user->setIsMobile(true);
                $em->persist($user);
                $em->flush();
            }
        }

        return $this->render("Frontend/Offer/view.html.twig", array(
            'offer' => $offer,
            'parentThematics' => $parentThematics,
        ));
    }
}