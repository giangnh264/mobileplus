<?php

class BxhController extends TController {

    public function actionIndex() {

        $callBack = (int) Yii::app()->request->getParam('call_back', 0);
        $page = (int) Yii::app()->request->getParam('page', 1);
        $limit = Yii::app()->params['numberPerPage'];
        $pageSize = Yii::app()->params['pageSize'];
        $c = CHtml::encode(Yii::app()->request->getParam('genre', 'VN'));
        $s = CHtml::encode(Yii::app()->request->getParam('type', 'SONG'));
        $s = strtoupper($s);
        $callBackLink = Yii::app()->createUrl("bxh/index", array('type' => $c, 's' => $s));
        if ($c == 'VN' || $c == 0)
            $cTitle =  Yii::t("wap","Việt Nam");
        if ($c == 'EUR')
            $cTitle = Yii::t("wap","Âu Mỹ");
        if ($c == 'KOR')
            $cTitle = Yii::t("wap","Châu Á");
        $sTitle = ($s == 'SONG') ? Yii::t("wap","Song") : $s;
        $options = array();
        $ccType= 'bxh';
        $collection = CollectionModel::model()->getCollectionByType($s, $ccType, $c, 0);
        $contentCode = $collection[0]->code;
        $count = WapSongModel::countListByCollection($contentCode);
        $topWeek = MainContentModel::getListByCollection($contentCode, $page, $limit);
        $options['col'] = $contentCode;
        
        $pager = new CPagination($count);
        $pager->setPageSize($limit);
        $type_name = strtolower($s);
        $ajaxview = "_ajax" . $type_name . "List";
        if ($callBack) {
            $this->layout = false;
            $this->render($ajaxview, compact('topWeek', 'pager', 'callBackLink', 'limit', 'options'));
        } else {
            $this->render('index', array(
                'topWeek' => $topWeek,
                's' => $s,
                'c' => $c,
                'cTitle' => $cTitle,
                'sTitle' => $sTitle,
                'pager' => $pager,
                'callBackLink' => $callBackLink,
                'options'=>$options
            ));
        }
    }

}