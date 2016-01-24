<?php
class ContactController extends Controller{

    public function actionIndex(){
        $this->render('index');
    }

    public function actionProject(){
        $form = "";
        $this->renderPartial ( '_project', compact ( "form" ), false, true );
    }
}