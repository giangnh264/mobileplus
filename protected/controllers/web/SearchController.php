<?php

class SearchController extends Controller
{
    public function actionIndex(){
        $keyword = Yii::app()->request->getParam('q');
        $order = Yii::app()->request->getParam('order', 1);
        $type = strtolower(Yii::app()->request->getParam('type','web'));
        $criteria = new CDbCriteria();
        $criteria->condition = 'type = :TYPE';
        $criteria->params = array(':TYPE'=>$type);
        $criteria->addSearchCondition('name', $keyword);
        $criteria->order = 'id desc';
        $product = ProductModel::model()->findAll($criteria);
    }
}