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

		$acl->addResource('public');        //view, logout, register
		$acl->addResource('admin');         //view, logout

        $acl->addResource('post');          //view,add,edit,delete
        $acl->addResource('postList');      //view
        $acl->addResource('comment');       //view,add,edit,delete
        $acl->addResource('commentList');   //view

        $acl->deny('guest');
		$acl->allow('guest','public','view');
        $acl->allow('guest','post','view');
        $acl->allow('guest','postList','view');
        $acl->allow('guest','comment','view');
        $acl->allow('guest','commentList','view');

        $acl->allow('user','comment','add');;
		$acl->deny('user','public','logout');

        $acl->allow('moderator','post','add');

        $acl->allow('admin');
		return $acl;
	}
}