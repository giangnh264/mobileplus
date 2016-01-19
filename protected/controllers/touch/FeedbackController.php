<?php

class FeedbackController extends TController {
	public function actionIndex()
	{
		$model = new FeedbackModel();
		if (isset($_POST['FeedbackModel'])) {
			$model->attributes = $_POST['FeedbackModel'];
			$model->setAttribute('phone', Yii::app()->user->getState('msisdn'));
			$model->setAttribute('created_datetime', date("Y-m-d H:i:s"));
			$model->setAttribute('version', 'WAP');
			if ($model->save()){
				Yii::app()->user->setState('msg','Vinaphone trân trọng cảm ơn quý khách đã góp ý cho dịch vụ. Chúng tôi sẽ liên tục cải tiến, nâng cao chất lượng để dịch vụ đáp ứng tốt hơn nhu cầu của quý khách!');
				$this->refresh();
				Yii::app()->end();
			}
		}
		$this->render('index', array(
				'model' => $model, 
		));
	}
}