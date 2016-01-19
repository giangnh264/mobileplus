<?php
class UserSubmenu extends CWidget{
    public $user;
    public $tab;
    
    public function run(){
        $this->render('submenu', array('user'=>$this->user, 'tab' => $this->tab));
    }
}
