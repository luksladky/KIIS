<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 12. 3. 2017
 * Time: 16:37
 */

namespace App\Model;

use App\Components\TMailer;
use Latte\Template;
use Latte\Engine;
use Nette,
    Nette\Database\Context as Database;
use Nette\Utils\DateTime;
use Tester\Environment;

class CronManager extends Repository
{
    use TMailer;

    protected $table = 'cron_task';

    /** @var  @var ProfileRepository */
    protected $profileRepository;

    /** @var  @var EventFacade */
    protected $eventFacade;

    /** @var  @var Database */
    protected $database;

    const EVENT_SIGN = 'event-sign'; //every day
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
        $tasks = $this->findBy('next_at < ?', new DateTime());

        foreach ($tasks as $task) {

            switch ($task->slug) {
                case self::USER_ACTIVITY:
                    $this->setNextCron(self::USER_ACTIVITY,7);
                    break;
                case self::EVENT_SIGN:

                    $usersWithEvents = $this->eventFacade->findNearestMaybe();

                    $skipIds = $this->profileRepository->findBy('upcoming_notif',false)->fetchPairs(null,'id');



                    $this->setNextCron(self::EVENT_SIGN,5);

                    foreach ($usersWithEvents as $userWithEvents) {
                        if (in_array($userWithEvents['user']->id,$skipIds)) continue;

                        $latte = new \Latte\Engine;
                        $latte->addFilter('timeagoinwords', 'App\Model\Filters::timeAgoInWords');
                        $template = $latte->renderToString(__DIR__ . '/../templates/Email/nearEventsEmail.latte',
                            ['events' => $userWithEvents['events'], 'baseUrl' => 'http://klub.ddmtrebic.cz']);

                        $this->sendMail($userWithEvents['user']->email, 'KIIS - přípomínka nadcházejících akcí', $template);
                    }
                    break;
            }
        }
    }

    private function setNextCron($task,$daysFromNow) {
        $this->findBy('slug',$task)->update(['next_at' =>(new DateTime())->add(new \DateInterval('P'.$daysFromNow.'D'))]);
    }
}