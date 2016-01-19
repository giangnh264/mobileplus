<?php
class DownloadController extends TController {
    public function actionAndroid() {
        // log visit here
        
        // redirect to google play
        $target = "market://details?id=vn.com.vega.chacha";
        $this->redirect($target);
    }
}
?>
