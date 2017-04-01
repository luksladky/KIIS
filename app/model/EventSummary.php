<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 25. 1. 2017
 * Time: 16:58
 */

namespace App\Model;


class EventSummary
{
    public $id;

    public $title;

    public $color;

    /**
     * EventSummary constructor.
     * @param $id
     * @param $title
     * @param $color
     */
    public function __construct($id, $title, $color)
    {
        $this->id = $id;
        $this->title = $title;
        $this->color = $color;
    }


}