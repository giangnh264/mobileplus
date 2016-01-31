<?php

class ProductController extends Controller
{
    public function actionIndex(){
        $pagesize = 12;
        $count =  ProductModel::model()->countProductByChannel('web');
        $page = new CPagination($count);
        $page->pageSize = $pagesize;
        $product_web = ProductModel::model()->getProductByChannel('web', $page->getLimit(), $page->getOffset());
        $this->render('index', compact( 'product_web', 'page'));
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