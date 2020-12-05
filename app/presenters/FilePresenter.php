<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 30. 7. 2018
 * Time: 10:14
 */

namespace App\Presenters;

use Nette;
use App\Model;
use App\Forms\ChangePasswordFormFactory;
use App\Forms\EditUserFormFactory;
use Nette\Database\Context as Database;


class FilePresenter extends BaseSecurePresenter
{
    public function renderDefault($filterType = '', $filterOwner = '', $order = 'date')
    {
        $this->template->ordering = $order;
        $this->template->filterType = $filterType;
        $this->template->filterOwner = $filterOwner;

        $filters = [];
        if ($filterType != '') {
            $filters['type'] = $filterType;
        }

        if ($filterOwner != '') {
            $filters['object_type'] = $filterOwner;
        }
        $this->template->files = $this->fileRepository->findBy($filters)->order($order . ' DESC');
    }
}