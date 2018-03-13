<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Thematic;
use AppBundle\Form\ThematicType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use AppBundle\Form\Search\OfferSearchType;

/**
 * @Route("/saSecureAlliance")
 */
class ThematicController extends Controller
{

    /**
     * @Route("/thematics/{numPage}/{offerId}", name="app_admin_thematic_list", defaults={"numPage" = 1}, requirements={"numPage": "\d+"})
     */
    public function listAction(Request $request, $numPage, $offerId = null)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(OfferSearchType::class);
        $offerId = $this->get('session')->get('thematicOfferId');
        $offer = $em->getRepository('AppBundle:Offer')->findOneById($offerId);
        $form->get('offer')->setData($offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('session')->set('thematicOfferId', $form->get('offer')->getData()->getId());

            return $this->redirectToRoute('app_admin_thematic_list', array(
                'offerId' => $offerId,
            ));
        }

        if ($offer) {
            $thematics = $em->getRepository('AppBundle:Thematic')->getByPage(
                $numPage,
                array(
                    'offer' => $offer,
                    'isTemplate' => false,
                )
            );
        } else {
            $thematics = $em->getRepository('AppBundle:Thematic')->getByPage(
                $numPage,
                array(
                    'isTemplate' => false,
                )
            );
        }

        $thematicTemplates = null;
        if ($numPage < 2 and !$offer) {
            $thematicTemplates = $em->getRepository('AppBundle:Thematic')->findBy(
                array(
                    'isTemplate' => true,
                    )
            );
        }

        $nbPages = ceil(count($thematics) / 20);
        if ($numPage > $nbPages && $nbPages > 0) {
            throw $this->createNotFoundException("The page was not found");
        }

        $offerId = $this->get('session')->get('thematicOfferId');
        $pagination = array(
            'numPage' => $numPage,
            'nbPages' => $nbPages,
            'route' => 'app_admin_thematic_list',
            'route_params' => array(
                'offerId' => $offerId
            )
        );

        return $this->render('Admin/Thematic/list.html.twig', array(
            'thematics' => $thematics,
            'thematicTemplates' => $thematicTemplates,
            'add_route' => 'app_admin_thematic_edit',
            'form' => $form->createView(),
            'offerId' => $offerId,
            'pagination' => $pagination,
        ));

    }

    /**
     * @Route("/thematic/edit/{thematicId}", name="app_admin_thematic_edit", requirements={"thematicId": "\d+"})
     * @Route("/thematic/add/{parentThematicId}", name="app_admin_add_sub_thematic", requirements={"parentThematicId": "\d+"})
     */
    public function editAction(Request $request, $thematicId = null, $parentThematicId = null)
    {
        $em = $this->getDoctrine()->getManager();

        if ($thematicId) {
            $thematic = $em->getRepository('AppBundle:Thematic')->findOneById($thematicId);

            if (!$thematic) {
                $this->get('session')->getFlashBag()->add('error', "La thématique est introuvable !");

                return $this->redirectToRoute('app_admin_thematic_list');
            }
        } else {
            $thematic = new Thematic();
        }

        if ($parentThematicId) {
            $parentThematic = $em->getRepository('AppBundle:Thematic')->findOneById($parentThematicId);
            $thematic->setParentThematic($parentThematic);
        }

        $slides = $em->getRepository('AppBundle:Slide')->findByThematic($thematicId);
        $form = $this->createForm(ThematicType::class, $thematic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->get('thumbnail')->getData() == null && $thematic->getThumbnail() == null) {
            $this->get('session')->getFlashBag()->add('error', "Veuillez ajouter une image.");
            $form->get('thumbnail')->get('file')->addError(new FormError('Veuillez ajouter une image.'));
        }

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($slides as $slide) {
                if (false === $thematic->getSlides()->contains($slide)) {
                    $em->remove($slide);
                }
            }

            $suiteNumber = 1;
            foreach ($form->get('slides')->getData() as $slide) {
                $suiteNumber++;
                $slide->setThematic($thematic);
                $slide->getMedia()->setSlide($slide);
                if (!$slide->getSuiteNumber()) {
                    $slide->setSuiteNumber($suiteNumber);
                }
            }

            if ($thematic->getIsTemplate()) {
                $thematic->setOffer(null);
            }

            if ($thematic->getParentThematic()) {
                $thematic->setIsTemplate($thematic->getParentThematic()->getIsTemplate());
                $thematic->setOffer($thematic->getParentThematic()->getOffer());
            }

            if (!$thematicId) {
                $maxSuiteNumber = $em->getRepository('AppBundle:Thematic')->getMaxSuiteNumber($thematic->getOffer(), $thematic->getParentThematic());
                $thematic->setSuiteNumber($maxSuiteNumber + 1);
            }

            $form->get('thumbnail')->getData()->setThematicThumbnail($thematic);
            $em->persist($thematic);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success',
                "La thématique a bien été éditée.");

            return $this->redirectToRoute('app_admin_thematic_edit', array('thematicId' => $thematic->getId()));
        }

        return $this->render('Admin/Thematic/edit.html.twig', array(
            'thematic' => $thematic,
            'form' => $form->createView(),
            'add_route' => 'app_admin_thematic_edit',
            'thematicId' => $thematicId,
        ));
    }

    /**
     *
     * @Route("/thematic/remove/{thematicId}", name="app_admin_thematic_remove",  requirements={"thematicId": "\d+"})
     */
    public function removeAction($thematicId = null)
    {
        $em = $this->getDoctrine()->getManager();
        $thematic = $em->getRepository('AppBundle:Thematic')->findOneById($thematicId);

        if (!$thematicId) {
            $this->get('session')->getFlashBag()->add('success', "La thématique est introuvable !");

            return $this->redirectToRoute('app_admin_thematic_list');
        }

        $this->get('session')->getFlashBag()->add('success', "La thématic a bien été supprimée.");

        $em->remove($thematic);
        $em->flush();

        return $this->redirectToRoute('app_admin_thematic_list');

    }

    /**
     *
     * @Route("/_ajax/thematics/sort", name="app_admin_thematics_sort")
     */
    public function sortAction(Request $request)
    {
        if ($request->isMethod('POST')) {

            $em = $this->getDoctrine()->getManager();
            $arrayOrder = $request->request->get('orderList');

            foreach ($arrayOrder as $key => $value) {
                $thematic = $em->getRepository('AppBundle:Thematic')->findOneById($value);
                $thematic->setSuiteNumber($key + 1);
                $em->persist($thematic);
            }

            $em->flush();

            return new \Symfony\Component\HttpFoundation\Response('valid');

        }

        return new \Symfony\Component\HttpFoundation\Response('error');

    }

    /**
     *
     * @Route("/thematic/search/remove", name="app_admin_thematic_search_remove")
     */
    public function searchRemoveAction()
    {
        $this->get('session')->remove('thematicOfferId');

        return $this->redirectToRoute('app_admin_thematic_list');
    }
}