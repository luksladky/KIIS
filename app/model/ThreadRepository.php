<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 1. 8. 2016
 * Time: 12:12
 */

namespace App\Model;

use Nette;
use Nette\Database;

class ThreadRepository extends Repository
{
    protected $table = "thread";

    /** order */
    const BY_DATE_CREATED = 'created',
        BY_DATE_LAST_POST = 'last_post';


    public static function getOrderFunction($orderBy = 'last_post',$desc = true) {
        $ascDesc = $desc ? 'DESC' : 'ASC';
        switch ($orderBy) {
            case self::BY_DATE_CREATED :
                return function (Database\Table\Selection $selection) use ($ascDesc) {
                    return $selection->order('created_at ' . $ascDesc);
                };
                break;
            case self::BY_DATE_LAST_POST :
            default :
                return function (Database\Table\Selection $selection) use ($ascDesc) {
                    return $selection->order('last_post ' . $ascDesc);
                };
                break;
        }
    }


}