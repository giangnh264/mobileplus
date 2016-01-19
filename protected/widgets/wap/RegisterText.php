<?php
/**
 * class RegisterText
 *
 * @author : longtv
 */
class RegisterText extends CWidget
{
    public $userSub;
    public $isPromotion;
    public $registerText;    
    
    public function init()
    {
    }

    public function run()
    {
        $this->render('RegisterTextWidget', array('userSub' => $this->userSub, 'isPromotion' => $this->isPromotion, 'registerText' => $this->registerText, ));
    }
}
?>
