<?php
//include_once('c_base.php');

class CArticles extends CBase
{
function  __construct($appli) {
        parent::__construct($appli);
    }

   function load()
   {

       if (isset($this->appli->urlVars['art_name']))
       {
         if (!$this->model->load($this->appli->urlVars['art_name']))
         {
           $this->model->data='not found';
         }

       }
         else
       $this->model->load($this->defaultArticle);

$this->view->load();


   }

}


?>