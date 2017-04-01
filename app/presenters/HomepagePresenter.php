<?php

namespace App\Presenters;

use App\Forms\EditHomepageFormFactory;
use App\Model\HomepageRepository;
use Nette;
use Nette\Database\Context as Database;

use App\Model\PermissionRepository as Permission;

class HomepagePresenter extends BaseSecurePresenter
{

    /** @var Database */
    public $database;

    /** @var HomepageRepository */
    public $homepageRepository;

    /** @var \Texy\Texy @inject */
    public $texy;

    /**
     * HomepagePresenter constructor.
     * @param $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->homepageRepository = new HomepageRepository($this->database);
    }


    public function renderDefault()
    {
        $this->template->homepage = $this->homepageRepository->findAll()->order('created_at DESC')->limit(1)->fetch();
    }


    public function actionEdit()
    {
        $content = $this->homepageRepository->findAll()->order('created_at DESC')->limit(1)->fetch()->content;

        $this['editHomepageForm']->setDefaults(['content' => $content]);
    }

    public function createComponentEditHomepageForm()
    {
        $form = (new EditHomepageFormFactory())->create();

        $form->onSuccess[] = array($this, 'editHomepageFormSucceeded');

        return $form;
    }

    public function editHomepageFormSucceeded($form, $values)
    {
        $this->onlyWithPermission(Permission::MODIFY_HOMEPAGE);

        $values['content'] = $this->texy->process($values['content']);

        $this->homepageRepository->insert(['content' => $values['content'], 'user_id' => $this->user->id]);

        $this->flashMessage('Hlavní stránka je zase aktuální, paráda.', 'success');
        $this->redirect('Homepage:default');
    }

}
