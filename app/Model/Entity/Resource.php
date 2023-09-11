<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Nette\Security\IResource;

class Resource implements IResource
{

    public function __construct(
        private string $resourceId,
        private int $authorId,
    ) {
    }

    public function getResourceId(): string
    {
        return $this->resourceId;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public static function create(string $resourceId, int $authorId): static
    {
        return new static(
            $resourceId,
            $authorId,
        );
    }
}