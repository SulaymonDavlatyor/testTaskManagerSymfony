<?php

namespace App\Service;

use App\Dto\CreateTaskDto;
use App\Dto\DeleteTaskDto;
use App\Dto\EditTaskDto;
use App\Dto\ShowTaskDto;
use App\Dto\TaskCompletedDto;
use App\Entity\Task;
use App\Exception\TaskException;
use App\Repository\TaskRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class TaskService
{
    private EntityManagerInterface $entityManager;
    private TaskRepository $taskRepository;


    public function __construct(
        EntityManagerInterface $entityManager,
        TaskRepository $taskRepository
    ) {
        $this->entityManager = $entityManager;
        $this->taskRepository = $taskRepository;
    }


    public function createTask(CreateTaskDto $dto): Task
    {
        $task = new Task();

        $task->setCreatedAt(DateTimeImmutable::createFromMutable(new DateTime()));
        $task->setDescription($dto->getDescription());
        $task->setHeader($dto->getHeader());
        $task->setCompleted(false);
        $task->setUserId($dto->getUserId());

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return $task;
    }

    public function editTask(EditTaskDto $dto): Task
    {
        $id = $dto->getId();
        $userId = $dto->getUserId();
        $task = $this->taskRepository->findOneBy(['id' => $id, 'userId' => $userId]);
        if (!$task) {
            throw TaskException::taskNotFound($id);
        }

        if ($dto->getDescription() !== null) {
            $task->setDescription($dto->getDescription());
        }
        if ($dto->getHeader() !== null) {
            $task->setHeader($dto->getHeader());
        }
        if ($dto->isCompleted() !== null) {
            $task->setCompleted($dto->isCompleted());
        }

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return $task;
    }

    public function getAllUserTasks(int $userId): array
    {
       $tasks = $this->taskRepository->findBy(['userId' => $userId]);
       if (!$tasks) {
           throw TaskException::userHasNoTasks();
       }
       return $tasks;
    }

    public function deleteTask(DeleteTaskDto $dto): void
    {
        $id = $dto->getId();
        $userId = $dto->getUserId();
        $task = $this->taskRepository->findOneBy(['id' => $id, 'userId' => $userId]);
        if (!$task) {
            throw TaskException::taskNotFound($id);
        }

        $this->entityManager->remove($task);
        $this->entityManager->flush();
    }

    public function showTask(ShowTaskDto $dto): Task
    {
        $id = $dto->getId();
        $userId = $dto->getUserId();
        $task = $this->taskRepository->findOneBy(['id' => $id, 'userId' => $userId]);
        if (!$task) {
            throw TaskException::taskNotFound($id);
        }
        return $task;
    }

    public function taskCompleted(TaskCompletedDto $dto): Task
    {
        $userId = $dto->getUserId();
        $id = $dto->getId();

        $task = $this->taskRepository->findOneBy(['id' => $id, 'userId' =>$userId]);
        if (!$task) {
            throw TaskException::taskNotFound($id);
        }
        $task->setCompleted(true);

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return $task;
    }

}
