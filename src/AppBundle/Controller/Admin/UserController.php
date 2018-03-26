<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Search\OfferSearchType;

/**
 * @Route("/saSecureAlliance")
 */
class UserController extends Controller
{

    /**
     * @Route("/users/{numPage}/{offerId}", name="app_admin_user_list", defaults={"numPage" = 1}, requirements={"numPage": "\d+"})
     * @Route("/users/{numPage}/{keyword}", name="app_admin_user_list", defaults={"numPage" = 1}, requirements={"numPage": "\d+"})
     */
    public function listAction(Request $request, $numPage, $offerId = null, $keyword = null)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(OfferSearchType::class);
        $offerId = $this->get('session')->get('userOfferId');
        $offer = $em->getRepository('AppBundle:Offer')->findOneById($offerId);
        $form->get('offer')->setData($offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('session')->set('userOfferId', $form->get('offer')->getData()->getId());

            return $this->redirectToRoute('app_admin_user_list', array(
                'offerId' => $offerId,
            ));
        }

        if ($offer) {
            $users = $em->getRepository('AppBundle:User')->getClientsByPage($numPage, array('offer' => $offer));
        } else {
            $users = $em->getRepository('AppBundle:User')->getClientsByPage($numPage);
        }

        $nbPages = ceil(count($users) / 20);
        if ($numPage > $nbPages && $nbPages > 0) {
            throw $this->createNotFoundException("The page was not found");
        }

        $pagination = array(
            'numPage' => $numPage,
            'nbPages' => $nbPages,
            'route' => 'app_admin_user_list',
            'route_params' => array(
                'offerId' => $offerId
            )
        );

        return $this->render('Admin/User/list.html.twig', array(
            'users' => $users,
            'add_route' => 'app_admin_user_edit',
            'form' => $form->createView(),
            'offerId' => $offerId,
            'pagination' => $pagination,
        ));

    }

    /**
     * @Route("/user/edit/{userId}", name="app_admin_user_edit")
     */
    public function editAction(Request $request, $userId = null)
    {
        $em = $this->getDoctrine()->getManager();

        if ($userId != null) {
            $user = $em->getRepository('AppBundle:User')->findOneById($userId);

            if (!$user) {
                $this->get('session')->getFlashBag()->add('error', "Le client est introuvable !");

                return $this->redirectToRoute('app_admin_user_list');
            }
        } else {
            $user = new User();
        }

        $form = $this->createForm(UserType::class, $user, array('isChange' => $userId ? true : false));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setEnabled(true);
            $this->get('session')->getFlashBag()->add('success',
                "Le client a bien été édité.");

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_admin_user_edit', array('userId' => $user->getId()));
        }

        return $this->render('Admin/User/edit.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
            'add_route' => 'app_admin_user_edit',
            'userId' => $userId,
        ));
    }

    /**
     *
     * @Route("/user/remove/{userId}", name="app_admin_user_remove")
     */
    public function removeAction($userId = null)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneById($userId);

        if (!$user) {
            $this->get('session')->getFlashBag()->add('error', "Le client est introuvable !");

            return $this->redirectToRoute('app_admin_user_list');
        }

        $this->get('session')->getFlashBag()->add('success', "Le client a bien été supprimée.");

        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('app_admin_user_list');

    }

    /**
     *
     * @Route("/user/search/remove", name="app_admin_user_search_remove")
     */
    public function searchRemoveAction()
    {
        $this->get('session')->remove('userOfferId');

        return $this->redirectToRoute('app_admin_user_list');
    }
}