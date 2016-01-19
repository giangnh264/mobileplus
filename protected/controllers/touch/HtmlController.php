<?php
/**
 * Created by PhpStorm.
 * User: KOI_GIANG
 * Date: 8/17/2015
 * Time: 1:45 PM
 */

class HtmlController extends TController {
    public function actionIndex() {
        $this->setPageTitle(Yii::t("web", "Guide"));
        $url_key = Yii::app()->request->getParam("url_key", null);
        $page = HtmlModel::model()->findByAttributes(array('url_key'=>$url_key));
        $this->render("index", array("content" => $page));
    }
}