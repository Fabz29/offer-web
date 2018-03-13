<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ThematicController extends Controller
{
    /**
     * @Route("/{slug}", name="app_thematic_view")
     */
    public function viewAction($slug)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $thematic = $em->getRepository('AppBundle:Thematic')->findOneBySlug($slug);

        if (!$thematic) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(404, "Thematic not found");
        }
        
        return $this->render('Frontend/Thematic/view.html.twig', array(
            'thematic' => $thematic,
        ));
    }
}