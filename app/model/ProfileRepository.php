<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 10. 8. 2016
 * Time: 14:03
 */

namespace App\Model;


use Nette\Bridges\DatabaseDI\DatabaseExtension;
use Nette\Utils\DateTime;

class ProfileRepository extends Repository
{
    protected $table = 'user';
    const IMAGE_NAMESPACE = 'profile';

    public function findAwaitingApproval() {
        return $this->findBy('approved_by_id',null);
    }
    
    public function findNotActive($howLong = '2 weeks') {
//        new \DateInterval()
    }
}