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
        $id = (int) Yii::app()->request->getParam('id');
        $product = ProductModel::model()->findbyPk($id);
        if(empty($product)){
            $this->forward("/index/error", true);
        }
        //san pham tuong tu
        $limit = 8;
        $product_relate = ProductModel::model()->getProductRelate($id, $product->channel, $limit);
        $this->render('view', compact('product'));
    }

    public function actionLoadmobile(){
        $this->renderPartial ( "_mobile" );
    }
    public function actionWeb(){
        $this->renderPartial ( "_web" );
    }

    public function actionSearch(){
        $keyword = Yii::app()->request->getParam('q');
        $keyword = CHtml::encode($keyword);
        $order = Yii::app()->request->getParam('order', 1);
        $channel = strtolower(Yii::app()->request->getParam('channel','web'));
        $pagesize = 12;
        $count =  ProductModel::model()->countsearchProduct($channel, $keyword);
        $page = new CPagination($count);
        $page->pageSize = $pagesize;
        $product_web = ProductModel::model()->searchProduct($channel, $keyword, $order, $page->getLimit(), $page->getOffset());
        $this->render('search', compact( 'product_web', 'page', 'keyword'));
    }

}