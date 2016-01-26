<?php
class AboutController extends Controller
{
    public function actionIndex(){
        $about = HtmlModel::model()->findByPk(1);
        $this->render('index', compact('about'));
    }
}