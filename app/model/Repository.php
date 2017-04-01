<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 29.12.2015
 * Time: 11:03
 */

namespace App\Model;

use Nette,
    Nette\Database\Context as Database;

abstract class Repository extends \Nette\Object
{
    /** @var Database */
    protected $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /** @var string */
    protected $table;

    /**
     * Vrátí všechny platné záznamy
     *
     * @return \Nette\Database\Table\Selection
     */
    public function findAll()
    {
        return $this->database->table($this->table);
    }


    /**
     * Vrátí kolekci záznamů podle podmínky
     *
     * @param string
     * @param array
     * @return \Nette\Database\Table\Selection
     */
    public function findBy($condition, $parameters = array())
    {
        return $this->findAll()->where($condition, $parameters);
    }


    /**
     * Vrátí záznam podle primárního klíče
     *
     * @param int
     * @return \Nette\Database\Table\ActiveRow|FALSE
     */
    public function get($id)
    {
        return $this->findAll()->get($id);
    }


    /**
     * @param $condition
     * @param array $parameters
     * @return bool|mixed|Nette\Database\Table\IRow
     */
    public function getBy($condition, $parameters = array())
    {
        return $this->findAll()->where($condition, $parameters)->fetch();
    }


    /**
     * Vloží nový záznam do tabulky
     *
     * @param array
     * @return \Nette\Database\Table\IRow|int
     */
    public function insert($data)
    {
        return $this->database->table($this->table)->insert($data);
    }


}