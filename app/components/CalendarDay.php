<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 25. 1. 2017
 * Time: 16:44
 */

namespace App\Components\Calendar;

use \blitzik\Calendar\Entities\Day;
use App\Model\EventSummary;

class CalendarDay extends Day
{
    /** @var EventSummary[] */
    public $events = [];

    /**
     * @return \App\Model\EventSummary[]
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param \App\Model\EventSummary[] $events
     */
    public function setEvents($events)
    {
        $this->events = $events;
    }

    /**
     * @param $id
     * @param $title
     * @param null $color
     */
    public function addEvent($id, $title, $color = null)
    {
        $this->events[] = new EventSummary($id, $title, $color);
    }





}