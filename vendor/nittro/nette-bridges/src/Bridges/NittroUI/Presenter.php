<?php
/**
 * Created by PhpStorm.
 * User: danik
 * Date: 26/02/16
 * Time: 12:44
 */

namespace Nittro\Bridges\NittroUI;
use Nette\Application\UI;


abstract class Presenter extends UI\Presenter {
    use PresenterUtils;


    protected function startup()
    {
        parent::startup();

        // Only redraw default snippets if nobody is receiving a signal
        $this->setRedrawDefault($this->getSignal() === NULL);
    }


    protected function afterRender()
    {
        parent::afterRender();

        if ($this->isAjax()) {
            // Redraw default snippets if enabled
            $this->redrawDefault();
        } else {
            $this->template->flashSession = $this->exportFlashSession();
        }
    }

    public function sendPayload()
    {
        // Send flash messages in payload
        $this->payload->flashes = $this->exportFlashSession();

        parent::sendPayload();
    }


}
