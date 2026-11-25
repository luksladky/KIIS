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

    /** Users who never clicked the email confirmation link. */
    public function findUnconfirmed() {
        // findBy() always passes a parameter array, which Nette 2.3 rejects for a bare IS NOT NULL condition
        return $this->findAll()->where('registration_token IS NOT NULL');
    }
}