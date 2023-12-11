<?php

namespace App\Controller;

use App\Dto\CreateTaskDto;
use App\Dto\DeleteTaskDto;
use App\Dto\EditTaskDto;
use App\Dto\ShowTaskDto;
use App\Dto\TaskCompletedDto;
use App\Entity\Task;
use App\Service\TaskService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/api')]
class TaskController extends AbstractController
{
    private TaskService $taskService;
    private Security $security;

    public function __construct(TaskService $taskService, Security $security){
        $this->taskService = $taskService;
        $this->security = $security;
    }

    #[Route('/tasks', name: 'app_task', methods: 'GET')]
    public function index(): Response
    {
        $userId = $this->security->getUser()->getId();
        $tasks = $this->taskService->getAllUserTasks($userId);
        return new Response(json_encode($tasks),200);
    }

    #[Route('/task', name: 'app_task_create',methods: 'POST')]
    public function create(#[MapRequestPayload] CreateTaskDto $taskDto)
    {
        $userId = $this->security->getUser()->getId();
        $taskDto->setUserId($userId);
        $task = $this->taskService->createTask($taskDto);

        return new Response(json_encode($task),200);
    }

    #[Route('/task/{id}', name: 'app_task_edit', methods: 'PUT')]
    public function edit(
        Request $request,
        #[MapRequestPayload] EditTaskDto $editTaskDto
    ) {
        $userId = $this->security->getUser()->getId();
        $editTaskDto->setId($request->get('id'));
        $editTaskDto->setUserId($userId);

        $task = $this->taskService->editTask($editTaskDto);

        return new Response(json_encode($task),200);
    }

    #[Route('/task/{id}', name: 'app_task_delete', methods: 'DELETE')]
    public function delete(Request $request): Response
    {
        $id = $request->get('id');
        $userId = $this->security->getUser()->getId();

        $dto = new DeleteTaskDto();
        $dto->setId($id);
        $dto->setUserId($userId);

        $this->taskService->deleteTask($dto);

        return new Response('success',200);
    }

    #[Route('/task/{id}', name: 'app_task_show', methods: 'GET')]
    public function show(Request $request): Response
    {
        $id = $request->get('id');
        $userId = $this->security->getUser()->getId();

        $dto = new ShowTaskDto();
        $dto->setId($id);
        $dto->setUserId($userId);

        $task = $this->taskService->showTask($dto);

        return new Response(json_encode($task),200);
    }


    #[Route('/task/{id}/completed', name: 'app_task_completed', methods: 'PUT')]
    public function completed(Request $request): Response
    {
        $userId = $this->security->getUser()->getId();

        $dto = new TaskCompletedDto();
        $dto->setUserId($userId);
        $dto->setId($request->get('id'));

        $task = $this->taskService->taskCompleted($dto);

        return new Response(json_encode($task),200);
    }

}
