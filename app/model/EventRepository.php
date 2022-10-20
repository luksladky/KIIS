<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 8. 8. 2016
 * Time: 22:23
 */

namespace App\Model;

use Nette\Database\Table\Selection;

class EventRepository extends Repository
{
    protected $table = 'event';

    /** order */
    const BY_DATE_CREATED = 'created_at',
        BY_DATE_FROM = 'upcoming';

    const EVENT_PUBLIC = 'public';
    const EVENT_EDUCATION = 'education';

    public static function getOrderFunction($orderBy = 'last_post',$desc = true) {
        $ascDesc = $desc ? 'DESC' : 'ASC';
        switch ($orderBy) {
            case self::BY_DATE_CREATED :
                return function (Selection $selection) use ($ascDesc) {
                    return $selection->order('created_at ' . $ascDesc);
                };
                break;
            case self::BY_DATE_FROM :
            default :
                return function (Selection $selection) use ($ascDesc) {
                    return $selection->order('date_from ' . $ascDesc);
                };
                break;
        }
    }
}