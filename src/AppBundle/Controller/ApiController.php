<?php
declare(strict_types=1);

/**
 * Api controller
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * ApiController
 */
class ApiController extends Controller
{
    /**
     * Get users with Ajax
     * @access public
     * @param Request $request
     * @param int $page
     * @Route(
     *     "/api/users/{page}",
     *     name="tdl_api_users",
     *     requirements={"page"="\d+"},
     *     methods={"GET"},
     *     condition="request.isXmlHttpRequest()"
     * )
     * 
     * @return JsonResponse
     */
    public function getUsersAction(Request $request, $page): JsonResponse
    {
        $users = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(User::class)
            ->getUsers($page);

        $datas = [];

        foreach ($users as $user) {       
            $data = [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'role' => $user->getRole()
            ];

            $datas[] = $data;
        }

        return new JsonResponse($datas);
    }
}