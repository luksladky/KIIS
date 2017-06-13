<?php
namespace App\Presenters;


use App\Components\TMailer;
use Nette;
use Nette\Application\UI\Form;
use Nittro\Bridges\NittroUI\Presenter;

class BasePresenter extends Presenter
{

    use \WebChemistry\Images\TPresenter;
    use TMailer;
    
    public function beforeRender()
    {
        parent::beforeRender();
        $this->template->isHttpError = false;
        $this->template->addFilter('timeagoinwords', 'App\Model\Filters::timeAgoInWords');
        $this->template->addFilter('czechdate', function ($date, $year = true){
            $en = array("January","February","March","April","May","June","July","August","September","October","November","December");
            $cz = array("ledna","února","března","dubna","května","června","července","srpna","září","října","listopadu","prosince");
            $d = $year ? $date->format('j. F Y') : $date->format('j. F');
            $dateFormatted = str_replace($en, $cz, $d);
            return $dateFormatted;
        } );


    }


}