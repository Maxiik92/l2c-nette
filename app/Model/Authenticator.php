<?php

declare(strict_types=1);

namespace App\Model;

use Exception;
use Nette;

use Nette\Security\Authenticator as NetteAuth;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;
use Nette\Security\SimpleIdentity;


class Authenticator implements NetteAuth {

    public function __construct(
        private UserModel $userModel,
        private RoleModel $rolemodel,
        private Passwords $passwords
    ){
    }

    /**
     * @inheritDoc
     */
    function authenticate(string $user, string $password): IIdentity{
        $row = $this->userModel
                ->getByEmail($user);
        bdump($row);

		if (!$row) {
			throw new Exception('User not found.');
		}

		if (!$this->passwords->verify($password, $row->password)) {
			throw new Exception('Invalid password.');
		}

        $user = $row->toArray();
        unset($user['password']);

		return new SimpleIdentity(
			$row->id,
            $this->rolemodel->findByUserIdToSelect($row->id),
			$user
		);
    }

}