<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\StatsUser;
use AppBundle\Entity\StatsOffer;
use Symfony\Component\HttpFoundation\Response;

class StatsUserController extends Controller
{
    /**
     * @Route("/stats/user/_ajax/time/add", name="app_stats_user_add_time")
     */
    public function addTimeAction(Request $request)
    {
        $user = $this->getUser();
        $time = ($request->get('time') / 1000);
        $em = $this->container->get('doctrine')->getEntityManager();
        $statsOffer = $em->getRepository('AppBundle:StatsOffer')->findOneByOffer($user->getOffer());

        $statsUser = $em->getRepository('AppBundle:StatsUser')->findOneBy(array(
            'user' => $user,
            'statsOffer' => $statsOffer
        ));

        if (!$statsUser) {
            $statsUser = new StatsUser();
            $statsUser->setStatsOffer($statsOffer);
            $statsUser->setUser($this->getUser());
            $statsUser->setUserName($user->getFirstName() . ' ' . $user->getLastName());
        }

        $statsUser->setTime($statsUser->getTime() + $time);
        $statsOffer->setTime($statsOffer->getTime() + $time);
        $statsOffer->addStatsUser($statsUser);
        $em->persist($statsOffer);
        $em->persist($statsUser);
        $em->flush();

        return new Response();
    }

    /**
     * @Route("/stats/user/offer/download", name="app_stats_user_download")
     */
    public function downloadAction()
    {
        $user = $this->getUser();
        $em = $this->container->get('doctrine')->getEntityManager();
        $statsOffer = $em->getRepository('AppBundle:StatsOffer')->findOneByOffer($this->getUser()->getOffer());
        $statsUser = $em->getRepository('AppBundle:StatsUser')->findOneBy(array(
            'statsOffer' => $statsOffer,
            'user' => $user,
        ));

        if (!$statsUser) {
            $statsUser = new StatsUser();
            $statsUser->setStatsOffer($statsOffer);
            $statsUser->setUser($this->getUser());
            $statsUser->setUserName($user->getFirstName() . ' ' . $user->getLastName());
        }

        $statsUser->setIsDownload(true);
        $statsOffer->setNumberDownload($statsOffer->getNumberDownload() + 1);
        $em->persist($statsOffer);
        $em->persist($statsUser);
        $em->flush();

        return $this->file($user->getOffer()->getFileDownload()->getWebPath());
    }
}