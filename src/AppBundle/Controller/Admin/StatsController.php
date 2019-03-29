<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Search\StatsSearchType;

/**
 * @Route("/saSecureAlliance")
 */
class StatsController extends Controller
{
    /**
     * @Route("/stats/view", name="app_admin_stats_view")
     */
    public function viewAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $statsOfferId = $this->get('session')->get('statsOfferId');
        $statsOffer = $em->getRepository('AppBundle:StatsOffer')->findOneById($statsOfferId);
        $form = $this->createForm(StatsSearchType::class);
        $form->get('statsOffer')->setData($statsOffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('session')->set('statsOfferId', $form->get('statsOffer')->getData()->getId());

            return $this->redirectToRoute('app_admin_stats_view');
        }

        if ($statsOffer) {
            return $this->render('Admin/Stats/offer.html.twig', array(
                'statsOffer' => $statsOffer,
                'form' => $form->createView()
            ));
        } else {
            $statsOffers = $em->getRepository('AppBundle:StatsOffer')->findAll();

            $numberDownloadGlobal = 0;
            $timeGlobal = 0;

            foreach ($statsOffers as $statsOffer) {
                $numberDownloadGlobal += $statsOffer->getNumberDownload();
                $timeGlobal += $statsOffer->getTime();
            }

            return $this->render('Admin/Stats/global.html.twig', array(
                'statsOffers' => $statsOffers,
                'numberDownloadGlobal' => $numberDownloadGlobal,
                'timeGlobal' => $timeGlobal,
                'form' => $form->createView()
            ));
        }

    }


    /**
     *
     * @Route("/stats/search/remove", name="app_admin_stats_search_remove")
     */
    public function searchRemoveAction()
    {
        $this->get('session')->remove('statsOfferId');

        return $this->redirectToRoute('app_admin_stats_view');
    }

}