<?php

class AdminUserController extends Controller
{
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new AdminGUserModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AdminGUserModel']))
		{
			$model->attributes=$_POST['AdminGUserModel'];
            $model->created_time = date('Y-m-d H:i:s');
            $model->updated_time = date('Y-m-d H:i:s');
			if($model->save())
				$this->redirect(array('view','id'=>$model->_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AdminUserModel']))
		{
			$model->attributes=$_POST['AdminUserModel'];
            $model->updated_time = date('Y-m-d H:i:s');
			if($model->save())
				$this->redirect(array('view','id'=>$model->_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model = new AdminGUserModel();
		$userInfo=null;
		if(isset($_GET['AdminGUserModel']))
		{
			$model->attributes = $_GET['AdminGUserModel'];
			$user_phone = Formatter::formatPhone($_GET['AdminGUserModel']['user_phone']);
			$userInfo = GUserModel::model()->findByAttributes(array('user_phone'=>$user_phone));
		}
		$this->render('index',array(
			'model'=>$model,
			'userInfo'=>$userInfo
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new AdminUserModel('search');
		$model->unsetAttributes();

		if(isset($_GET['AdminUserModel']))
			$model->setAttributes($_GET['AdminUserModel']);

		$this->render('admin', array(
			'model'=>$model
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AdminUserModel::model()->findByPk(new MongoId($id));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-user-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
