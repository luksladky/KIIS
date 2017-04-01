<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 12. 3. 2017
 * Time: 16:37
 */

namespace App\Model;

use Nette,
    Nette\Database\Context as Database;

class CronManager extends Repository
{

    protected $table = 'cron_task';

    /** @var  @var ProfileRepository */
    protected $profileRepository;

    /** @var  @var EventFacade */
    protected $eventFacade;

    /** @var  @var Database */
    protected $database;

    const EVENT_SIGN = 'event-sing'; //every day
    const USER_ACTIVITY = 'user-activity'; //every week

    /**
     * CronManager constructor.
     * @param ProfileRepository $profileRepository
     * @param EventFacade $eventFacade
     * @param Database $database
     */
    public function __construct(ProfileRepository $profileRepository, EventFacade $eventFacade, Database $database)
    {
        $this->profileRepository = $profileRepository;
        $this->eventFacade = $eventFacade;
        $this->database = $database;
    }


    public function check()
    {
        $tasks = $this->findBy('next_at < ?', new Nette\Utils\DateTime());

        foreach ($tasks as $task) {
            dump($task->slug);
            switch ($task->slug) {
                case self::USER_ACTIVITY:
//$                 this->eventFacade->
//                  
                    break;
                case self::EVENT_SIGN:

                    break;
            }
        }
    }

}