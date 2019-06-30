<?php
declare(strict_types=1);

/**
 * Api controller
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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
     * Get unknow tasks with Ajax
     * @access public
     * @param int $page
     * @Route(
     *     "/api/tasks/unknow/{page}",
     *     name="tdl_api_tasks_unknow",
     *     requirements={"page"="\d+"},
     *     methods={"GET"},
     *     condition="request.isXmlHttpRequest()"
     * )
     * @Security("has_role('ROLE_ADMIN')")
     * 
     * @return JsonResponse
     */
    public function getUnknowTasksAction($page): JsonResponse
    {
        $tasks = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Task::class)
            ->getUnknowTasks($page);

        $datas = [];

        foreach ($tasks as $task) {       
            $data = [
                'id' => $task->getId(),
                'title' => $task->getTitle(),
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

    /**
     * Delete task with Ajax
     * @access public
     * @param int $id
     * @Route(
     *     "/api/tasks/{id}",
     *     name="tdl_api_tasks_delete",
     *     requirements={"id"="\d+"},
     *     methods={"DELETE"},
     *     condition="request.isXmlHttpRequest()"
     * )
     * 
     * @return JsonResponse
     */
    public function deleteTaskAction(Task $task): JsonResponse
    {
        if ($task->getUser() && !$this->getUser()->isEqualTo($task->getUser())) {
            throw new AccessDeniedHttpException();
        }

        if (!$task->getUser() && $this->getUser()->getRole() !== 'ROLE_ADMIN') {
            throw new AccessDeniedHttpException();
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($task);

        $manager->flush();

        return new JsonResponse(null, 204);
    }
}