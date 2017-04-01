<?php
namespace App\Model;

use Nette;

class Authorizator extends Nette\Object implements Nette\Security\IAuthorizator
{

    /** @var Nette\Security\Permission */
    private $acl;

    /**
     * UserAuthorizator constructor.
     * @param Nette\Security\Permission $acl
     */
    public function __construct()
    {
        $acl = new Nette\Security\Permission;

        $acl->addRole('guest');
        $acl->addRole('member','guest');
        $acl->addRole('event_manager','member');
        $acl->addRole('admin','event_manager');


        $acl->addResource('backend');
        $acl->addResource('post');
        $acl->addResource('user');
        $acl->addResource('event');
        $acl->addResource('thread');

        $acl->allow('member','thread','comment');
        $acl->allow('member','post','add');

        $acl->allow('event_manager','event');

        $acl->allow('admin','post','edit');
        $acl->allow('admin','post','delete');
        $acl->allow('admin', 'user', 'add');
        $acl->allow('admin', 'user', 'editAll');

        $acl->allow('admin'); //full access to administrator

        $this->acl = $acl;
    }


    function isAllowed($role, $resource, $privilege = self::ALL)
    {
        return $this->acl->isAllowed($role,$resource,$privilege);
    }

}