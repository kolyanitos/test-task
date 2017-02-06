<?php


namespace App\Controller;


use App\Entity\Task;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaskController extends MainController
{
    public function listAction(Request $request)
    {
        $this->context['tasks'] = $this->getRepository()->getTable($request->query->all());

        return $this->htmlResponse($this->twig->render('tasks/list.html.twig', $this->context));
    }

    public function addAction(Request $request)
    {
        $this->context['action'] = 'add';

        if ($request->getMethod() === 'POST') {
            $taskData = $request->request->get('task');
            $image = $request->files->get('image');

            $task = $this->add($taskData, $image);
            if ($task) {
                $this->context['notify'] = 'Task added';
            }
        }

        return $this->htmlResponse($this->twig->render('tasks/modify.html.twig', $this->context));
    }

    public function previewAction(Request $request)
    {
        $returns = [
            'status' => false,
            'content' => ''
        ];

        if ($request->getMethod() === 'POST') {
            $taskData = $request->request->get('task');
            $image = $request->files->get('image');

            $task = $this->add($taskData, $image, false);
            if ($task) {
                $returns['content'] = $this->twig->render('tasks/preview.html.twig', ['task' => $task]);
                $returns['status'] = true;
            }
        }

        return $this->jsonResponse($returns);
    }

    public function editAction(Request $request, $id)
    {
        if ($this->user and $this->user->getRole() === 'ROLE_ADMIN') {
            $this->context['action'] = 'edit';
            $this->context['task'] = $this->getRepository()->find($id);

            if (!$this->context['task']) {
                throw new NotFoundHttpException('No task found');
            }

            if ($request->getMethod() === 'POST') {
                $taskData = $request->request->get('task');
                $taskData['id'] = $id;

                $task = $this->edit($taskData);
                if ($task) {
                    $this->context['notify'] = 'Task edited';
                }
            }

            return $this->htmlResponse($this->twig->render('tasks/modify.html.twig', $this->context));
        }

        throw new AccessDeniedHttpException('No permission');
    }

    private function add($taskData, $image, $flush = true)
    {
        if (isset($taskData['email'], $taskData['username'], $taskData['description'])) {
            $taskData['email'] = trim($taskData['email']);
            $taskData['username'] = trim($taskData['username']);
            $taskData['description'] = trim($taskData['description']);

            if (!empty($taskData['email']) and !empty($taskData['username']) and !empty($taskData['description'])) {
                return $this->getRepository()->add($taskData, $image, $flush);
            }
        }

        $this->context['task'] = $taskData;
        $this->context['errors'] = ['Please fill in required fields'];

        return null;
    }

    private function edit($taskData) {
        $taskData['user'] = $this->user;

        if (isset($taskData['description'])) {
            return $this->getRepository()->edit($taskData, $this->context['task']);
        }

        $this->context['task'] = $taskData;
        $this->context['errors'] = ['Edit error'];

        return null;
    }

    private function getRepository() {
        return $this->em->getRepository(Task::class);
    }
}