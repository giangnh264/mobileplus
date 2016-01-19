<?php
/**
 * class WapCommonFunctions
 * define common functions to use in wapsite
 *
 * @author : longtv
 */
class WapCommonFunctions extends VegaCommonFunctions
{
    public static function getBannerViVas($width,$heigh)
    {
    	$time = time();

		if($width >=720 ){
			$script = <<<EOD
			<script type='text/javascript'><!--//<![CDATA[
			   var m3_u = (location.protocol=='https:'?'https://adsnet.vn/AdsNetwork/www/delivery/ajs.php':'http://adsnet.vn/AdsNetwork/www/delivery/ajs.php');
			   var m3_r = Math.floor(Math.random()*99999999999);
			   if (!document.MAX_used) document.MAX_used = ',';
			   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
			   document.write ("?zoneid=71");
			   document.write ('&amp;cb=' + m3_r);
			   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
			   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
			   document.write ("&amp;loc=" + escape(window.location));
			   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
			   if (document.context) document.write ("&context=" + escape(document.context));
			   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
			   document.write ("'><\/scr"+"ipt>");
			//]]>--></script>
			<noscript>
			<a href='http://adsnet.vn/AdsNetwork/www/delivery/ck.php?n=a32a2981&amp;cb=$time' target='_blank'>
			<img src='http://adsnet.vn/AdsNetwork/www/delivery/avw.php?zoneid=71&amp;cb=$time&amp;n=a32a2981' border='0' alt='' />
			</a>
			</noscript>

EOD;
		}elseif($width>=480){
			$script = <<<EOD
			<script type='text/javascript'><!--//<![CDATA[
			   var m3_u = (location.protocol=='https:'?'https://adsnet.vn/AdsNetwork/www/delivery/ajs.php':'http://adsnet.vn/AdsNetwork/www/delivery/ajs.php');
			   var m3_r = Math.floor(Math.random()*99999999999);
			   if (!document.MAX_used) document.MAX_used = ',';
			   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
			   document.write ("?zoneid=70");
			   document.write ('&amp;cb=' + m3_r);
			   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
			   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
			   document.write ("&amp;loc=" + escape(window.location));
			   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
			   if (document.context) document.write ("&context=" + escape(document.context));
			   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
			   document.write ("'><\/scr"+"ipt>");
			//]]>--></script>
			<noscript>
			<a href='http://adsnet.vn/AdsNetwork/www/delivery/ck.php?n=aa80f985&amp;cb=$time' target='_blank'>
			<img src='http://adsnet.vn/AdsNetwork/www/delivery/avw.php?zoneid=70&amp;cb=$time&amp;n=aa80f985' border='0' alt='' />
			</a>
			</noscript>

EOD;
		}else{
			$script = <<<EOD
			<script type='text/javascript'><!--//<![CDATA[
			   var m3_u = (location.protocol=='https:'?'https://adsnet.vn/AdsNetwork/www/delivery/ajs.php':'http://adsnet.vn/AdsNetwork/www/delivery/ajs.php');
			   var m3_r = Math.floor(Math.random()*99999999999);
			   if (!document.MAX_used) document.MAX_used = ',';
			   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
			   document.write ("?zoneid=68");
			   document.write ('&amp;cb=' + m3_r);
			   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
			   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
			   document.write ("&amp;loc=" + escape(window.location));
			   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
			   if (document.context) document.write ("&context=" + escape(document.context));
			   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
			   document.write ("'><\/scr"+"ipt>");
			//]]>--></script>
			<noscript>
			<a href='http://adsnet.vn/AdsNetwork/www/delivery/ck.php?n=ae32512f&amp;cb=$time' target='_blank'>
			<img src='http://adsnet.vn/AdsNetwork/www/delivery/avw.php?zoneid=68&amp;cb=$time&amp;n=ae32512f' border='0' alt='' />
			</a>
			</noscript>
EOD;
		}
		return $script;
    }
}
?>
