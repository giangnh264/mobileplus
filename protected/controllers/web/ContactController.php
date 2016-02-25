<?php
class ContactController extends Controller{

    public function actionIndex(){
        $messages = "";
        $error_type = "";
        $success = "";
        $name = "";
        $email = "";
        $description = "";
        $error = false;
        if (Yii::app ()->getRequest ()->ispostRequest) {
            $name = Yii::app()->request->getParam('name');
            $email = Yii::app()->request->getParam('email');
            $description = Yii::app()->request->getParam('description');
            if(empty($name)){
                $error = true;
                $error_type = 'name';
                $messages = "Vui lòng nhập họ tên!";
            }elseif(!EmailHelper::isEmailAddress($email)){
                $error = true;
                $error_type = 'email';
                $messages = "Email không hợp lệ!";
            }elseif(empty($description)){
                $error = true;
                $error_type = 'description';
                $messages = "Vui lòng nhập thông tin liên hệ !";
            }else{
                $contact = new ContactModel();
                $contact->name = $name;
                $contact->content  = $description;
                $contact->email = $email;
                $contact->project_des =  !empty(Yii::app()->session['project_des']) ? Yii::app()->session['project_des'] : '';
                $contact->project_name = !empty(Yii::app()->session['project_name']) ? Yii::app()->session['project_name'] : '';
                $contact->project_pirce = !empty(Yii::app()->session['project_price']) ? Yii::app()->session['project_price'] : '';
                $contact->project_type = !empty(Yii::app()->session['project_type']) ? Yii::app()->session['project_type'] : '';
                $contact->project_time = !empty(Yii::app()->session['project_time']) ? Yii::app()->session['project_time'] : '';
                $contact->created_time = date('Y-m-d H:i:s');
                $contact->save();
                $success = true;
                $messages = "Quý khách đã gửi liên hệ thành công, chúng tôi sẽ liên hệ lại trong thời gian sớm nhất!";
            }
        }
            $this->render('index', compact('error', 'messages', 'error_type', 'name', 'email', 'description', 'success'));
    }

    public function actionProject(){
        $form = "";
        if (Yii::app ()->getRequest ()->ispostRequest) {
            $project_des = Yii::app()->request->getParam('project_des');
            $project_price = Yii::app()->request->getParam('project_price');
            $project_name = Yii::app()->request->getParam('project_name');
            $project_type = Yii::app()->request->getParam('project_type');
            $project_time = Yii::app()->request->getParam('project_time');
            if($project_des != ''){
                Yii::app()->session['project_des'] = Yii::app()->request->getParam('project_des');
            }
            if($project_name != ''){
                Yii::app()->session['project_name'] = Yii::app()->request->getParam('project_name');
            }
            if($project_price != ''){
                Yii::app()->session['project_price'] = Yii::app()->request->getParam('project_price');
            }
            if($project_type != ''){
                Yii::app()->session['project_type'] = Yii::app()->request->getParam('project_type');
            }
            if($project_time != ''){
                Yii::app()->session['project_time'] = Yii::app()->request->getParam('project_time');
            }
            echo 'success!';
        }
        $this->renderPartial ( '_project', compact ( "form" ), false, true );
    }
}