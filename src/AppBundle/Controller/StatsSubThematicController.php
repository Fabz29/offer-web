<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\StatsUser;
use AppBundle\Entity\StatsSubThematic;
use Symfony\Component\HttpFoundation\Response;

class StatsSubThematicController extends Controller
{
    /**
     * @Route("/stats/subThematic/{subThematicId}/_ajax/time/add", name="app_stats_subThematic_add_time")
     */
    public function addTimeAction(Request $request, $subThematicId)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $user = $this->getUser();
        $subThematic = $em->getRepository('AppBundle:Thematic')->findOneById($subThematicId);
        $time = ($request->get('time') / 1000);
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

        $statsSubThematic = $em->getRepository('AppBundle:StatsSubThematic')->findOneBy(array(
            'subThematic' => $subThematic,
            'statsUser' => $statsUser
        ));

        if (!$statsSubThematic) {
            $statsSubThematic = new StatsSubThematic();
            $statsUser->addStatsSubThematic($statsSubThematic);
            $em->persist($statsUser);
            $statsSubThematic->setStatsUser($statsUser);
            $statsSubThematic->setSubThematic($subThematic);
            $statsSubThematic->setSubThematicName($subThematic->getTitle());
        }

        $statsSubThematic->setTime($statsSubThematic->getTime() + $time);
        $em->persist($subThematic);
        $em->flush();

        return new Response();
    }

}