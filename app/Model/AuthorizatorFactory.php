<?php

namespace App\Model;
use Nette\StaticClass;
use Nette\Security\Permission;

class AuthorizatorFactory
{
    use StaticClass;
	public static function create(): Permission
	{
		$acl = new Permission;
		$acl->addRole('guest');
		$acl->addRole('user','guest');
		$acl->addRole('moderator','user');
		$acl->addRole('admin');

		$acl->addResource('public');
		$acl->addResource('admin');
		$acl->addResource('signin');
		$acl->addResource('signout');
        $acl->addResource('post');
        $acl->addResource('postList');
        $acl->addResource('comment');
        $acl->addResource('commentList');

        $acl->deny('guest');
		$acl->allow('guest','signin','view');
		$acl->deny('guest','signout','view');
		$acl->allow('guest','public','view');
        $acl->allow('guest','post','view');
        $acl->allow('guest','postList','view');
        $acl->allow('guest','comment','view');
        $acl->allow('guest','commentList','view');

        $acl->allow('user','comment','create');
        $acl->allow('user','signout','view');
		$acl->deny('user','signin','view');

        $acl->allow('moderator','post','edit');

        $acl->allow('admin');
        $acl->deny('admin','signin','view');
		return $acl;
	}
}