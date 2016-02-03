<?php

class ProductController extends Controller
{
    public function actionIndex(){
        $channel  = Yii::app()->request->getParam('channel', 'web');
        if(strtolower($channel) == 'web'){
            $other_channel = 'app';
        }else{
            $other_channel = 'web';
        }
        $order = Yii::app()->request->getParam('order', 1);
        $pagesize = 12;
        $count =  ProductModel::model()->countProductByChannel($other_channel);
        $page = new CPagination($count);
        $page->pageSize = $pagesize;
        $product_web = ProductModel::model()->getProductByChannel($other_channel, $page->getLimit(), $page->getOffset(), $order);
        $this->render('index', compact( 'product_web', 'page', 'channel', 'other_channel', 'order'));
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
        //log san pham
        $statistic = StatisticProductModel::model()->findbyAttributes(array('product_id'=>$id));
        if(!empty($statistic)){
            $count = $statistic->view_count;
            $count = $count + 1;
            $statistic->view_count = $count;
            $statistic->save(false);
        }else{
            $statistic = new StatisticProductModel();
            $statistic->product_id = $id;
            $statistic->view_count = 1;
            $statistic->save(false);
        }
        //san pham tuong tu
        $limit = 8;
        $product_relate = ProductModel::model()->getProductRelate($id, $product->channel, $limit);
        //get list slider product
        $slider = ProductImgModel::model()->getSliderByProductId($id);
        $this->render('view', compact('product', 'product_relate', 'slider'));
    }

    public function actionLoadmobile(){
        $this->renderPartial ( "_mobile" );
    }
    public function actionWeb(){
        $this->renderPartial ( "_web" );
    }

    public function actionSearch(){
        $keyword = Yii::app()->request->getParam('q');
        if($keyword == ''){
            $this->redirect(Yii::app()->homeUrl);
        }
        $keyword = Common::RemoveXSS($keyword);
        $order = Yii::app()->request->getParam('order', 1);
        $channel = strtolower(Yii::app()->request->getParam('channel','web'));
        $pagesize = 12;
        $count =  ProductModel::model()->countsearchProduct($channel, $keyword);
        $page = new CPagination($count);
        $page->pageSize = $pagesize;
        $product_web = ProductModel::model()->searchProduct($channel, $keyword, $order, $page->getLimit(), $page->getOffset());
        $this->render('search', compact( 'product_web', 'page', 'keyword','order', 'channel', 'count'));

    }

}