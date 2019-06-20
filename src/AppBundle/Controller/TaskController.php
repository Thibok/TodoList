<?php

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

/**
 * TaskController
 */
class TaskController extends Controller
{
    /**
     * @Route("/tasks", name="task_list")
     */
    public function listAction()
    {
        return $this->render('task/list.html.twig', ['tasks' => $this->getDoctrine()->getRepository('AppBundle:Task')->findAll()]);
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
            
            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Edit Task
     * @access public
     * @param Task $task
     * @param Request $request
     * @param CaptchaChecker $captchaChecker
     * @Route("/tasks/{id}/edit", name="tdl_task_edit")
     * 
     * @return Response|RedirectResponse
     */
    public function editAction(Task $task, Request $request, CaptchaChecker $captchaChecker): Response
    {
        if (!$this->getUser()->isEqualTo($task->getUser())) {
            throw new AccessDeniedHttpException();
        }

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $captchaChecker->check($request) && $form->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'La tâche a bien été modifiée.');
            } catch(ORMException $exception) {
                $this->addFlash('error', 'Une erreur est survenue.');
            }

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task)
    {
        $task->toggle(!$task->isDone());
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(Task $task)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
