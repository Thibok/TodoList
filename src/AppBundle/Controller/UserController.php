<?php

/**
 * User Controller
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\ParamChecker\CaptchaChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * UserController
 */
class UserController extends Controller
{
    /**
     * @Route("/users", name="user_list")
     */
    public function listAction()
    {
        return $this->render('user/list.html.twig', ['users' => $this->getDoctrine()->getRepository('AppBundle:User')->findAll()]);
    }

    /**
     * Create User
     * @access public
     * @param Request $request
     * @param CaptchaChecker $captchaChecker
     * @Route("/users/create", name="tdl_user_create")
     * 
     * @return Response|RedirectResponse
     */
    public function createAction(Request $request, CaptchaChecker $captchaChecker): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $captchaChecker->check($request) && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);

            try {
                $manager->flush();
                $this->addFlash('success', "L'utilisateur a bien été ajouté.");
            } catch (ORMException $exception) {
                $this->addFlash('error', 'Une erreur est survenue.');
            }

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Edit User
     * @access public
     * @param User $user
     * @param CaptchaChecker $captchaChecker
     * @param Request $request
     * @Route("/users/{id}/edit", name="tdl_user_edit")
     * 
     * @return Response|RedirectResponse
     */
    public function editAction(User $user, CaptchaChecker $captchaChecker, Request $request): Response
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $captchaChecker->check($request) && $form->isValid()) {
            
            try {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', "L'utilisateur a bien été modifié");
            } catch (ORMException $exception) {
                $this->addFlash('error', 'Une erreur est survenue.');
            }

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}
