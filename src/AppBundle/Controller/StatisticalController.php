<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StatisticalController extends Controller
{
    /**
     * @Route("/statistical/_ajax/time/spent", name="app_statistical_time_spent")
     */
    public function timeSpentAction()
    {
       $user = $this->getUser();
    }
}