<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Slide;
use AppBundle\Form\SlideType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/saSecureAlliance")
 */
class SlideController extends Controller
{
    /**
     *
     * @Route("/slides", name="app_admin_slide_list")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $slides = $em->getRepository('AppBundle:Slide')->findBy(array(), array('createdAt' => 'DESC'));

        return $this->render('Admin/Slide/list.html.twig', array(
            'slides' => $slides,
            'add_route' => 'app_admin_slide_edit'
        ));
    }

    /**
     *
     * @Route("/slide/edit/{slideId}", name="app_admin_slide_edit")
     */
    public function editAction(Request $request, $slideId = null)
    {
        $em = $this->getDoctrine()->getManager();

        if ($slideId != null) {
            $slide = $em->getRepository('AppBundle:Slide')->findOneById($slideId);

            if (!$slide) {
                $this->get('session')->getFlashBag()->add('error', "La slide est introuvable !");

                return $this->redirectToRoute('app_admin_slide_list');
            }

        } else {
            $slide = new Slide();
        }

        $form = $this->createForm(SlideType::class, $slide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('picture')->getData())
                $form->get('picture')->getData()->setSlide($slide);
            $em->persist($slide);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "La slide a bien été modifiée.");
        }

        return $this->render('Admin/Slide/edit.html.twig', array(
            'slide' => $slide,
            'form' => $form->createView(),
            'add_route' => 'app_admin_slide_edit',
            'slideId' => $slideId,
        ));
    }

    /**
     *
     * @Route("/slide/remove/{slideId}", name="app_admin_slide_remove")
     */
    public function removeAction($slideId)
    {
        $em = $this->getDoctrine()->getManager();
        $slide = $em->getRepository('AppBundle:Slide')->findOneById($slideId);


        if (!$slide) {
            $this->get('session')->getFlashBag()->add('error', "La slide est introuvable !");

            return $this->redirectToRoute('app_admin_slide_list');
        }

        $this->get('session')->getFlashBag()->add('warning', "La slide a bien été supprimée.");

        $em->remove($slide);
        $em->flush();

        return $this->redirectToRoute('app_admin_slide_list');

    }
}
