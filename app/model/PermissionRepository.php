<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 23. 1. 2017
 * Time: 19:59
 */

namespace App\Model;


class PermissionRepository extends Repository
{
    const MEMBER = 'member',
        ADD_THREAD = 'add-thread',
        ADD_EVENT = 'add-event',
        MANAGE_THREADS = 'manage-threads',
        MANAGE_EVENTS = 'manage-events',
        MODIFY_HOMEPAGE = 'modify-homepage',
        MODIFY_USER = 'modify-user';


    protected $table = 'user_permission';

    protected $tablePermissions = 'permission';

    public function addPermission($userId, $permissionSlug)
    {
//        dump($userId,$permissionSlug);
        return $this->insert(['user_id' => $userId, 'permission_slug' => $permissionSlug]);
    }

    public function removePermission($userId, $permissionSlug)
    {
//        dump($userId,$permissionSlug);
        return $this->findBy('user_id = ? AND permission_slug = ?', [$userId, $permissionSlug])->delete();
    }

    public function addPermissionsUpToLevel($userId, $level)
    {

        $permissions = $this->database->table($this->tablePermissions)->where('security_level <= ?', $level)->fetchPairs(null, 'slug');

        foreach ($permissions as $permission) {
            $this->addPermission($userId, $permission);
        }
    }


    public function findPermissions()
    {
        return $this->database->table($this->tablePermissions)->order('security_level ASC');
    }

    public function findByUser($userId)
    {
        return $this->findBy('user_id', $userId)->fetchPairs(null, 'permission_slug');
    }


}