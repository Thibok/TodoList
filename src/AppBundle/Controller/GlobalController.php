<?php
declare(strict_types=1);

/**
 * The global controller
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * GlobalController
 */
class GlobalController extends Controller
{
    /**
     * Get homepage
     * @access public
     * @Route("/", name="tdl_global_homepage")
     * 
     * @return Response
     */
    public function indexAction(): Response
    {
        return $this->render('global/index.html.twig');
    }
}
