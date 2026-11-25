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


    /** Permission groups shown in the admin UI; toggling a group adds/removes all its permissions. */
    public static $groups = [
        'member' => [
            'label'       => 'Člen',
            'description' => 'Může se přihlásit, číst a psát do diskuzí a hlásit se na akce.',
            'permissions' => [self::MEMBER],
        ],
        'thread' => [
            'label'       => 'Zakládat diskuze',
            'description' => 'Může zakládat nové diskuze na nástěnce.',
            'permissions' => [self::ADD_THREAD],
        ],
        'event'  => [
            'label'       => 'Přidávat akce',
            'description' => 'Může přidávat nové akce do kalendáře.',
            'permissions' => [self::ADD_EVENT],
        ],
        'admin'  => [
            'label'       => 'Admin',
            'description' => 'Spravuje diskuze, akce, úvodní stránku a uživatele včetně jejich práv.',
            'permissions' => [self::MANAGE_THREADS, self::MANAGE_EVENTS, self::MODIFY_HOMEPAGE, self::MODIFY_USER],
        ],
    ];

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


    /** Adds all permissions of a group (plus membership, without which nobody can log in). */
    public function addGroup($userId, $groupKey)
    {
        $wanted = array_unique(array_merge([self::MEMBER], self::$groups[$groupKey]['permissions']));
        foreach (array_diff($wanted, $this->findByUser($userId)) as $slug) {
            $this->addPermission($userId, $slug);
        }
    }

    public function removeGroup($userId, $groupKey)
    {
        foreach (self::$groups[$groupKey]['permissions'] as $slug) {
            $this->removePermission($userId, $slug);
        }
    }

    /** @return array groupKey => 'full' | 'partial' | 'none' */
    public static function groupStates(array $assignedSlugs)
    {
        $states = [];
        foreach (self::$groups as $key => $group) {
            $has = count(array_intersect($group['permissions'], $assignedSlugs));
            $states[$key] = $has === count($group['permissions']) ? 'full' : ($has > 0 ? 'partial' : 'none');
        }
        return $states;
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