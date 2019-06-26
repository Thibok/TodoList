<?php
declare(strict_types=1);

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * Login
     * @access public
     * @param AuthenticationUtils $authenticationUtils
     * @Route("/login", name="tdl_login")
     * 
     * @return Response
     */
    public function loginAction(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('tdl_global_homepage');
        }

        return $this->render('security/login.html.twig', array(
            'last_username' => $authenticationUtils->getLastUsername(),
            'error'         => $authenticationUtils->getLastAuthenticationError(),
        ));
    }

    /**
     * Logout
     * @access public
     * @Route("/logout", name="tdl_logout")
     * 
     * @return void
     */
    public function logoutAction() 
    {
    
    }
}
