<?php
class ContactController extends Controller{

    public function actionIndex(){
        if (Yii::app ()->getRequest ()->ispostRequest) {
            die('1');
        }
            $this->render('index');
    }

    public function actionProject(){
        $form = "";
        if (Yii::app ()->getRequest ()->ispostRequest) {
            session_start();
            $project_des = Yii::app()->request->getParam('project_des');
            $project_price = Yii::app()->request->getParam('project_price');
            $project_name = Yii::app()->request->getParam('project_name');
            $project_type = Yii::app()->request->getParam('project_type');
            if($project_des != ''){
                $_SESSION['project_des'] = Yii::app()->request->getParam('project_des');
            }
            if($project_name != ''){
                $_SESSION['project_name']= Yii::app()->request->getParam('project_name');
            }
            if($project_price != ''){
                $_SESSION['project_price'] = Yii::app()->request->getParam('project_price');
            }
            if($project_type != ''){
                $_SESSION['project_type'] = Yii::app()->request->getParam('project_type');
            }
            exit;
        }
        $this->renderPartial ( '_project', compact ( "form" ), false, true );
    }
}