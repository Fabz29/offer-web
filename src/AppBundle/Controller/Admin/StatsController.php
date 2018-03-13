<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/saSecureAlliance")
 */
class StatsController extends Controller
{
    /**
     *
     * @Route("/stats/view", name="app_admin_stats_view")
     */
    public function viewAction()
    {
        return $this->render('Admin/Stats/view.html.twig');
    }
}