<?php

namespace App\Exception;

use App\Entity\Task;
use Symfony\Component\HttpFoundation\Response;
use RuntimeException;
use Throwable;

class TaskException extends RuntimeException
{
    const TASK_NOT_FOUND_MESSAGE = "Task with id %d not found";
    const USER_HAS_NO_TASKS = "You have no tasks";

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function taskNotFound(int $id): TaskException
    {
        $message = sprintf(self::TASK_NOT_FOUND_MESSAGE, $id);
        return new TaskException($message, Response::HTTP_NOT_FOUND);
    }

    public static function userHasNoTasks(): TaskException
    {
        return new TaskException(self::USER_HAS_NO_TASKS, Response::HTTP_NOT_FOUND);
    }

}