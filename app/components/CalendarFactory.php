<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 25. 1. 2017
 * Time: 16:36
 */

namespace App\Components\Calendar;

use \blitzik\Calendar\Factories\HorizontalCalendarCellFactory;
use \blitzik\Calendar\Entities;

class CalendarFactory extends HorizontalCalendarCellFactory
{
    /** @var int */
    private $year;

    /** @var int */
    private $month;

    /** @var int */
    private $calendarStartDay;

    /** @var int */
    private $weekStartDay = 0;

    public function __construct($weekStartDay = 0)
    {
        parent::__construct($weekStartDay); 
        $this->weekStartDay = $weekStartDay;
    }

    public function setPeriod($year, $month)
    {
        $this->year = $year;
        $this->month = $month;

        $d = \DateTime::createFromFormat('!Y-m', $year . '-' . $month);
        $this->calendarStartDay = $this->getCountStart((int)date('w', $d->getTimestamp()));
    }



    /** Returns "distance" between calendar start day and first day of the month
     *
     * @param int $firstWeekDayOfMonth numeric representation of the day of the week
     * @return int
     */
    private function getCountStart($firstWeekDayOfMonth)
    {
        $start = 0; // if they are equal
        if ($this->weekStartDay < $firstWeekDayOfMonth) {
            $start = $firstWeekDayOfMonth - $this->weekStartDay;
        }

        if ($this->weekStartDay > $firstWeekDayOfMonth) {
            $start = 7 - ($this->weekStartDay - $firstWeekDayOfMonth);
        }

        return $start - 1;
    }

    /**
     * @param int $row
     * @param int $col
     * @return CalendarCell
     */
    public function createCell($row, $col)
    {
        return new CalendarCell(
            $this->calcNumber($row, $col),
            $this->year,
            $this->month,
            $this->isForDayLabel($row, $col)
        );
    }

    /**
     * @return int
     */
    public function getNumberOfRows()
    {
        return 7;
    }



    /**
     * @return int
     */
    public function getNumberOfColumns()
    {
        return 7;
    }



    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }



    /**
     * @return int
     */
    public function getMonth()
    {
        return $this->month;
    }



    /**
     * @return int
     */
    public function getCalendarStartDay()
    {
        return $this->calendarStartDay;
    }



    public function getWeekStartDay()
    {
        return $this->weekStartDay;
    }
}