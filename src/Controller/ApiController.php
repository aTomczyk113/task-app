<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/task/{id}", name="show_task", methods={"GET"})
     */
    public function show(Request $request, Task $task)
    {
        return new JsonResponse([
            'id' => $task->getId(),
            'content' => $task->getContent(),
            'datetime' => $task->getDate()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * @Route("/new", name="new_task", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $content = $request->request->get('content');

        $user = $userRepository->find(1);

        $task = new Task();
        $task->setUser($user);
        $task->setContent(trim($content));
        $task->setDate(new \DateTime());
        $task->setDone(false);

        $entityManager->persist($task);
        $entityManager->flush();

        $response = new JsonResponse(['json' => $content]);

        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @Route("/delete", name="delete_task", methods={"POST"})
     */
    public function delete(Request $request, TaskRepository $taskRepository, EntityManagerInterface $entityManager)
    {
        $id = $request->request->get('id');
        $task = $taskRepository->find($id);

        $entityManager->remove($task);
        $entityManager->flush();

        $response = new JsonResponse(['state' => true]);

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * @Route("/showAll", name="list", methods={"GET"})
     */
    public function showAll(TaskRepository $taskRepository, UserRepository $userRepository)
    {
        $tasks = $taskRepository->findBy(['user' => $userRepository->find(1)]);

        $newFormatArrayTask = [];

        foreach ($tasks as $t) {
            $newFormatArrayTask[] = [
                'id' => $t->getId(),
                'content' => $t->getContent(),
                'datetime' => $t->getDate()->format('Y-m-d H:i:s')
            ];
        }

        $response = new JsonResponse($newFormatArrayTask);

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }
}