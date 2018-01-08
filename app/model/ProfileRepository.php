<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 10. 8. 2016
 * Time: 14:03
 */

namespace App\Model;


class ProfileRepository extends Repository
{
    protected $table = 'user';
    const IMAGE_NAMESPACE = 'profile';

    public function findAwaitingApproval() {
        return $this->findBy('approved_by_id',null);
    }
}