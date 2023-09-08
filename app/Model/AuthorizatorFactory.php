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
        ;
        $acl->deny('user', 'public', 'logout');

        $acl->allow('moderator', 'post', 'add');
        $acl->allow('moderator', 'post', 'edit', []);
        $acl->allow('moderator', 'post', 'delete');

        $acl->allow('admin');
        return $acl;
    }
    public static function checkEditPost(Permission $acl, string $role, string $resource, string $privilege): bool
    {
        $role = $acl->getQueriedRole(); // object Registered
        $resource = $acl->getQueriedResource(); // object Article
        return $role->id === $resource->authorId;
    }
}