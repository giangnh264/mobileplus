<?php
$submenu = include  '_submenu.php';
$controller = $this->getId();
$action = $this->action->id;
switch ($controller){
	case "newsEvent":
		$group = "cms";
		break;

	case "admin":
	default:
		$group = $controller;
		break;
}
$module = isset($this->module) ? $this->module->id : '';

$links = isset($submenu[$group])?$submenu[$group]:array();
if($group == 'reports'){
	$menu =  include '_menu.php';
	foreach($menu as $menu){
		if(isset($menu['key']) && $menu['key'] =='reports'){
			$links = $menu;
			break;
		}
	}
}

echo '<h6 id="h-menu-products" class="selected">
<a href="#"><span>'. ucfirst($this->getId()). '</span></a>
</h6>';
if(!empty($links) && $group != "admin-user")
{	
		$this->widget('application.widgets.admin.menu.SMenu',
								array(
								"menu"=>$links,
								"stylesheet"=>"menu_blue.css",
								"menuID"=>"sub_menu",
								"delay"=>3,
								"isSub"=>true
								)
		);

}
?>

