<?php

namespace App\Model;

use App\Model\Entity\Resource;
use Nette\StaticClass;
use Nette\Security\Permission;

class AuthorizatorFactory
{
    use StaticClass;
    public static function create(): Permission
    {
        $acl = new Permission;
        $acl->addRole('guest');
        $acl->addRole('user', 'guest');
        $acl->addRole('moderator', 'user');
        $acl->addRole('admin');

        $acl->addResource('public'); //view, logout, register
        $acl->addResource('admin'); //view, logout

        $acl->addResource('post'); //view,add,edit,delete
        $acl->addResource('postGrid'); //view
        $acl->addResource('comment'); //view,add,edit,delete
        $acl->addResource('commentGrid'); //view

        $acl->deny('guest');
        $acl->allow('guest', 'public', 'view');
        $acl->allow('guest', 'post', 'view');
        $acl->allow('guest', 'postGrid', 'view');
        $acl->allow('guest', 'comment', 'view');
        $acl->allow('guest', 'commentGrid', 'view');

        $acl->allow('user', 'comment', 'add');
        $acl->allow('user', 'comment', 'edit',		[self::class, 'checkResourceManipulateAsAuthor']);
        $acl->allow('user', 'comment', 'delete',	[self::class, 'checkCommentDelete']);
        $acl->allow('user', 'public', 'logout');

        $acl->allow('moderator', 'post', 'add');
        $acl->allow('moderator', 'post', 'edit',	[self::class, 'checkResourceManipulateAsAuthor']);
        $acl->allow('moderator', 'post', 'delete',	[self::class, 'checkResourceManipulateAsAuthor']);

        $acl->allow('admin');
        return $acl;
    }
    public static function checkResourceManipulateAsAuthor(Permission $acl, string $role, string $resource, string $privilege): bool
    {
        $role = $acl->getQueriedRole(); // object Registered
        $resource = $acl->getQueriedResource(); // object Article
        return $role->getUserId() === $resource->author_id;
    }

	public static function checkCommentDelete(Permission $acl, string $role, string $resource, string $privilege): bool{
		$queriedRole = $acl->getQueriedRole();
        $queriedResource = $acl->getQueriedResource();
        return self::checkResourceManipulateAsAuthor($acl, $role, $resource, $privilege) || $queriedRole->getUserId() === $queriedResource->author_id;
	}

}