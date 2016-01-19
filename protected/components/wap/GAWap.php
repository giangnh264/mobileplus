<?php
class GAWap {
    public static $GA_ACCOUNT = "MO-1344246-22";
    public static $GA_PIXEL = "/ga.php";
    
    public static function googleAnalyticsGetImageUrl() {
        $GA_ACCOUNT = self::$GA_ACCOUNT;
        $GA_PIXEL = Yii::app()->homeUrl.self::$GA_PIXEL;
        $url = "";
        $url .= $GA_PIXEL . "?";
        $url .= "utmac=" . $GA_ACCOUNT;
        $url .= "&utmn=" . rand(0, 0x7fffffff);
        $referer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"";
        $query = isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:"";
        $path = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:"";
        if (empty($referer)) {
            $referer = "-";
        }
        $url .= "&utmr=" . urlencode($referer);
        if (!empty($path)) {
            $url .= "&utmp=" . urlencode($path);
        }
        $url .= "&guid=ON";
        return str_replace("&", "&amp;", $url);
    }
}
?>