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
        $retVal = $this->findByUserId($id)
            ->fetchPairs('id', 'name');

        if ($returnAsEntity) {
            $retVal = array_map(
                function (string $name) use ($id) {
                    return Role::create($id, $name);
                },
                $retVal
            );
        }

        return $retVal;
    }

}