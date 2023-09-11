<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Entity\Role;
use Nette;
use Nette\Database\Table\Selection;


class RoleModel extends BaseModel
{
    use Nette\SmartObject;

    public function getTableName(): string
    {
        return 'role';
    }


    public function findByUserId(int $id): Selection
    {
        return $this->getTable()
            ->where(':user_x_role.user_id', $id);
    }

    public function findByUserIdToSelect(int $id, bool $returnAsEntity = false): array
    {
        return $this->findByUserId($id)
            ->fetchPairs('id', 'name');
    }

    public function findAllByUserIdAsEntity(int $id): array {
        return array_map(
            function (string $name) use ($id) {
                return Role::create($id, $name);
            },
            $this->findByUserIdToSelect($id),
        );
    }
}