<?php
declare(strict_types=1);

/**
 * Task Controller
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use Doctrine\ORM\ORMException;
use AppBundle\ParamChecker\CaptchaChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * TaskController
 */
class TaskController extends Controller
{
    /**
     * List tasks
     * @access public
     * @Route("/tasks/{status}", name="tdl_task_list", requirements={"status"="current|finish"})
     * 
     * @return Response
     */
    public function listAction($status): Response
    {
        $user = $this->getUser();

        $isDone = ($status == 'current') ? false : true;

        $tasks = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Task::class)
            ->getTasks(1, $user->getId(), $isDone)
        ;

        return $this->render(
            'task/list.html.twig',
            ['tasks' => $tasks, 'isDone' => $isDone]
        );
    }

    /**
     * Create Task
     * @access public
     * @param Request $request
     * @param CaptchaChecker $captchaChecker
     * @Route("/tasks/create", name="tdl_task_create")
     * 
     * @return Response|RedirectResponse
     */
    public function createAction(Request $request, CaptchaChecker $captchaChecker): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $captchaChecker->check($request) && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $task->setUser($this->getUser());
            $manager->persist($task);

            try {
                $manager->flush();
                $this->addFlash('success', 'La tâche a bien été ajoutée.');
            } catch(ORMException $exception) {
                $this->addFlash('error', 'Une erreur est survenue.');
            }
            
            return $this->redirectToRoute('tdl_task_list', ['status' => 'current']);
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Edit Task
     * @access public
     * @param Task $task
     * @param Request $request
     * @param CaptchaChecker $captchaChecker
     * @Route("/tasks/{id}/edit", name="tdl_task_edit", requirements={"id"="\d+"})
     * @Security("user.isEqualTo(task.getUser())")
     * 
     * @return Response|RedirectResponse
     */
    public function editAction(Task $task, Request $request, CaptchaChecker $captchaChecker): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $captchaChecker->check($request) && $form->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'La tâche a bien été modifiée.');
            } catch(ORMException $exception) {
                $this->addFlash('error', 'Une erreur est survenue.');
            }

            return $this->redirectToRoute(
                'tdl_task_list',
                ['status' => ($task->isDone()) ? 'finish' : 'current']
            );
        }

        return $this->render(
            'task/edit.html.twig',
            ['form' => $form->createView(), 'task' => $task]
        );
    }

    /**
     * Toggle Task
     * @access public
     * @param Task $task
     * @Route("/tasks/{id}/toggle", name="tdl_task_toggle", requirements={"id"="\d+"})
     * @Security("user.isEqualTo(task.getUser())")
     * 
     * @return RedirectResponse
     */
    public function toggleTaskAction(Task $task): RedirectResponse
    {
        $task->toggle(!$task->isDone());

        try {
            $this->getDoctrine()->getManager()->flush();

            $message = ($task->isDone())
                ? 'La tâche %s a bien été marquée comme faite.'
                : 'La tâche %s a bien été marquée comme non faite.'
            ;

            $this->addFlash('success', sprintf($message, $task->getTitle())); 

        } catch(ORMException $exception) {
            $this->addFlash('error', 'Une erreur est survenue.');
        }

        return $this->redirectToRoute(
            'tdl_task_list',
            ['status' => ($task->isDone()) ? 'current' : 'finish']
        );
    }
}
