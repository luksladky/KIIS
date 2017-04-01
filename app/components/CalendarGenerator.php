<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 25. 1. 2017
 * Time: 16:39
 */

namespace App\Components\Calendar;


use \blitzik\Calendar\Generator\CalendarGenerator as Generator;
use blitzik\Calendar\Factories\ICellFactory;
use App\Model\EventFacade;

class CalendarGenerator extends Generator
{
    /** @var CalendarFactory  */
    protected $cellFactory;

    /** @var EventFacade */
    protected $eventFacade;

    /**
     * CalendarGenerator constructor.
     * @param ICellFactory $cellFactory
     * @param EventFacade $eventFacade
     */
    public function __construct(ICellFactory $cellFactory, EventFacade $eventFacade)
    {
        parent::__construct($cellFactory);
        $this->cellFactory = $cellFactory;
        $this->eventFacade = $eventFacade;
    }


    protected function generateCalendar($year, $month)
    {
        $this->cellFactory->setPeriod($year, $month);

        $calendarTable = [];
        for ($row = 0; $row < $this->cellFactory->getNumberOfRows(); $row++) {
            for ($col = 0; $col < $this->cellFactory->getNumberOfColumns(); $col++) {
                $cell = $this->cellFactory->createCell($row, $col);
                $day = $cell->getDay();

                $events = $this->eventFacade->findForDay($day->getYear(),$day->getMonth(),$day->getDay());

                foreach ($events as $event) {
                    $day->addEvent($event->id, $event->title, null);
                }

                $calendarTable[$cell->getNumber()] = $cell;
            }
        }

        return $calendarTable;
    }


}