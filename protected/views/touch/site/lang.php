<?php
$this->layout = false;
header("Content-type: text/javascript");
echo "var LANG = [] ;\n";
foreach($data as $key=>$val){
                $key = addslashes($key);
				$val = addslashes($val);
                echo "LANG['$key']='$val';\n";
}
$script = "
function __t(key) {
				if(LANG[key]){
					return LANG[key];
				}
				return key;
			}
		";
echo $script;
Yii::app()->end();
?>

