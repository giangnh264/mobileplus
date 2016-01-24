<?php

/**
 * Created by PhpStorm.
 * User: TUYETBOM
 * Date: 1/15/2016
 * Time: 10:20 PM
 */
class ProductController extends Controller
{
    public function actionIndex(){
        $this->render('index');
    }

    public function actionMobile(){
        $this->render('mobile');
    }

    public function actionView(){
        $this->render('view');
    }

    public function actionLoadmobile(){
        $this->renderPartial ( "_mobile" );
    }
    public function actionWeb(){
        $this->renderPartial ( "_web" );
    }

}