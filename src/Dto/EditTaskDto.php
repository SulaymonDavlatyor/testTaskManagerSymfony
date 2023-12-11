<?php

namespace App\Dto;

use DateTime;
use Symfony\Component\Validator\Constraints\Type;

class EditTaskDto
{
    private int $id;

    private int $userId;

    #[Type('string')]
    private ?string $header = null;

    #[Type('string')]
    public ?string $description;

    #[Type('bool')]
    private ?bool $completed = null;

    #[Type('dateTime')]
    private ?DateTime $completedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getHeader(): null|string
    {
        return $this->header;
    }

    public function setHeader(string $header): void
    {
        $this->header = $header;
    }

    public function getDescription(): null|string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function isCompleted(): null|bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): void
    {
        $this->completed = $completed;
    }

    public function getCompletedAt(): ?\DateTimeImmutable
    {
        return $this->completedAt;
    }

    public function setCompletedAt(string $completedAt): void
    {
        $this->completedAt = new DateTime($completedAt);
    }
}