<?php

class AdminEventController extends Controller
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
		$model=new AdminEventModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AdminEventModel']))
		{
			$model->attributes=$_POST['AdminEventModel'];
            $model->created_time = date('Y-m-d H:i:s');
            $model->created_by = Yii::app()->user->id;
            $groupId = $_POST['AdminEventModel']['group_id'];
            $groupName = EventGroupModel::model()->findByPk(new MongoId($groupId))->name;
            $model->group_name = $groupName;
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

		if(isset($_POST['AdminEventModel']))
		{
			$model->attributes=$_POST['AdminEventModel'];
            $model->updated_time = date('Y-m-d H:i:s');
            $model->updated_by = Yii::app()->user->id;
            $groupId = $_POST['AdminEventModel']['group_id'];
            $groupName = EventGroupModel::model()->findByPk(new MongoId($groupId))->name;
            $model->group_name = $groupName;
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
			//$this->loadModel($id)->delete();
			$model = $this->loadModel($id);
            $model->status=0;
            $model->save(false);

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
		$dataProvider=new EMongoDocumentDataProvider('AdminEventModel');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		/*$model = new AdminEventModel('search');
		$model->unsetAttributes();

		if(isset($_GET['AdminEventModel'])) {
            $model->setAttributes($_GET['AdminEventModel']);
        }*/
		/*$this->render('admin', array(
			'model'=>$model
		));*/
        $model = new AdminEventModel('search');
        if(isset($_GET['AdminEventModel'])) {
            $model->setAttributes($_GET['AdminEventModel']);
        }
        $dataProvider=new EMongoDocumentDataProvider('AdminEventModel');
        $c = array();
        if(isset($_GET['AdminEventModel'])){
            $name = $_GET['AdminEventModel']['name'];
            $description = $_GET['AdminEventModel']['description'];
            $status = $_GET['AdminEventModel']['status'];
            $reset = $_GET['AdminEventModel']['reset'];
            $group_id = $_GET['AdminEventModel']['group_id'];
            if($status!='' && is_numeric($status)){
                $c['conditions']['status'] = array('==' => (int) $status);
            }
            if(is_numeric($reset)){
                $c['conditions']['reset'] = array('==' => (int) $reset);
            }
            if(!empty($group_id)){
                $c['conditions']['group_id'] = array('==' => $group_id);
            }
            if(!empty($name)){
                $c['conditions']['name'] = array('==' => new MongoRegex('/['.$name.'].*/i'));
            }
            if(!empty($description)){
                $c['conditions']['description'] = array('==' => new MongoRegex('/['.$description.'].*/i'));
            }
        }
        $c['sort'] = array('_id'=>EMongoCriteria::SORT_DESC);
        $dataProvider->setCriteria($c);
        $paging = new CPagination();
        $paging->pageSize=20;
        $dataProvider->setPagination($paging);
        $this->render('admin',array(
            'dataProvider'=>$dataProvider,
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
		$model=AdminEventModel::model()->findByPk(new MongoId($id));
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-event-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
