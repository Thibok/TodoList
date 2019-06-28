<?php
declare(strict_types=1);

/**
 * Api controller
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * ApiController
 */
class ApiController extends Controller
{
    /**
     * Get users with Ajax
     * @access public
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
    public function getUsersAction($page): JsonResponse
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

    /**
     * Get current/finish tasks with Ajax
     * @access public
     * @param int $page
     * @param string $status
     * @Route(
     *     "/api/tasks/{status}/{page}",
     *     name="tdl_api_tasks",
     *     requirements={"status"="current|finish", "page"="\d+"},
     *     methods={"GET"},
     *     condition="request.isXmlHttpRequest()"
     * )
     * 
     * @return JsonResponse
     */
    public function getTasksAction($page, $status): JsonResponse
    {
        $user = $this->getUser();

        $isDone = ($status == 'current') ? false : true;

        $tasks = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Task::class)
            ->getTasks($page, $user->getId(), $isDone);

        $datas = [];

        foreach ($tasks as $task) {       
            $data = [
                'id' => $task->getId(),
                'title' => $task->getTitle(),
                'content' => $task->getContent(),
            ];

            $datas[] = $data;
        }

        return new JsonResponse($datas);
    }
}