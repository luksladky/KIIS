<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 25. 1. 2017
 * Time: 16:43
 */

namespace App\Components\Calendar;

use \blitzik\Calendar\Entities\Cell;
use App\Model\EventSummary;

class CalendarCell extends Cell
{

    /** @var CalendarDay */
    private $day;

    protected function createDay()
    {
        
        $day =  new CalendarDay($this);
        return $day;
    }

    /**
     * @return CalendarDay
     */
    public function getDay()
    {
        if (!isset($this->day)) {
            $this->day = $this->createDay();
        }

        return $this->day;
    }


}