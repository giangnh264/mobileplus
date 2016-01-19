<?php

class AdminUserEventController extends Controller
{
	public $time;
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
		$model=new AdminUserEventModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AdminUserEventModel']))
		{
			$model->attributes=$_POST['AdminUserEventModel'];
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

		if(isset($_POST['AdminUserEventModel']))
		{
			$model->attributes=$_POST['AdminUserEventModel'];
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
		if(isset($_GET['adminUserEvent'])){
			if (isset($_GET['songreport']['date']) && $_GET['songreport']['date'] != "") {
				$createdTime = $_GET['songreport']['date'];
				if (strrpos($createdTime, "-")) {
					$createdTime = explode("-", $createdTime);
					$fromDate = explode("/", trim($createdTime[0]));
					$fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
					$toDate = explode("/", trim($createdTime[1]));
					$toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
					$this->time = array('from' => $fromDate, 'to' => $toDate);
				} else {
					$time = explode("/", trim($_GET['songreport']['date']));
					$time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
					$this->time = array('from' => $time, 'to' => $time);
				}
			} else {
				$fromDate = '2015-10-05';
				$toDate = date("Y-m-d");
				$this->time = array('from' => $fromDate, 'to' => $toDate);
			}
			$userPhone = Formatter::formatPhone($_GET['adminUserEvent']['user_phone']);
			$first_date = $this->time['from'] . ' 00:00:00';
			$end_date   = $this->time['to'] . ' 23:59:59';
			$count = UserEventModel::model()->countbyUserByTime($userPhone, $first_date, $end_date);
			$page = new CPagination($count);
			$page->pageSize = 30;
			$dataProvider = UserEventModel::model()->getbyUserByTime($userPhone, $page->getLimit(), $page->getOffset(), $first_date, $end_date);
			$point = $this->getPointByTime($userPhone, $first_date, $end_date);
			$point = isset($point["result"][0]["total"]) ? $point["result"][0]["total"] : 0;
			//export
			if(isset($_GET['Export']) && $_GET['Export']=='Export'){
				$this->layout=false;
				header('Content-type: application/vnd.ms-excel');
				header("Content-Disposition: attachment; filename=diem_thue_bao_". $userPhone."_".$this->time['from']."_den_".$this->time['to'].".xls");
				header("Pragma: no-cache");
				header("Expires: 0");
				$dataProvider = $this->getbyUserByTime($userPhone, $first_date, $end_date);
				$this->render('_export_user_event',array(
					'point' => $point,
					'dataProvider' => $dataProvider,
					'first_date'=>$first_date,
					'end_date'=>$end_date,
				));
				exit();
			}
		}
		$this->render('index',array(
			'dataProvider'	=> $dataProvider,
			'point'	  	  	=> $point,
			'page'			=> $page,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
        //test
        /*$chk = UserEventModel::checkIsLogAfterTime('84942111185',778042,'5551b17f0379950c0900002b');
        var_dump($chk);
        exit;*/
        $model = new AdminUserEventModel('search');
        if(isset($_GET['AdminUserEventModel'])) {
            $model->setAttributes($_GET['AdminUserEventModel']);
        }
        $dataProvider=new EMongoDocumentDataProvider('AdminUserEventModel');
        $c = array();
        if(isset($_GET['AdminUserEventModel'])) {
            //$model->setAttributes($_GET['AdminUserEventModel']);
            $method = $_GET['AdminUserEventModel']['method'];
            $user_id = $_GET['AdminUserEventModel']['user_id'];
            $user_phone = $_GET['AdminUserEventModel']['user_phone'];
            $user_phone = Formatter::formatPhone($user_phone);
            $event_id = $_GET['AdminUserEventModel']['event_id'];
            $point = $_GET['AdminUserEventModel']['point'];

            if($method!=''){
                $c['conditions']['method'] = array('==' => $method);
            }
            if(!empty($user_id)){
                $c['conditions']['user_id'] = array('==' => (int) $user_id);
            }
            if(!empty($user_phone)){
                $c['conditions']['user_phone'] = array('==' => $user_phone);
            }
            if(!empty($event_id)){
                $c['conditions']['event_id'] = array('==' => $event_id);
            }
            if(!empty($point)){
                $c['conditions']['point'] = array('==' => (int) $point);
            }
        }
        $c['sort'] = array('_id'=>EMongoCriteria::SORT_DESC);
        $dataProvider->setCriteria($c);
        $paging = new CPagination();
        $paging->pageSize=30;
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
		$model=AdminUserEventModel::model()->findByPk(new MongoId($id));
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-user-event-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function getPointByTime($userPhone, $first_date, $end_date){
		return $result = UserEventModel::model()->aggregate('user_event', array(
			array('$match'=>array(
				'created_time'=>array('$gte'=>$first_date, '$lte'=>$end_date),
			)),
			array('$match'=>array(
				'user_phone'=>$userPhone,
			)),
			array(
				'$group'=>array('_id'=>'$user_phone', 'total'=>array('$sum'=>'$point')),
			),
		));
	}

	public function getbyUserByTime($user_phone, $first_date, $end_date){
		$criteria = new EMongoCriteria;
		$criteria = array(
			'conditions'=>array(
				'user_phone'=>array('==' => $user_phone),
				'created_time'=>array('>='=>$first_date.' 00:00:00', '<='=>$end_date.' 23:59:59'),
				'point'=>array('>'=>0),
			),
			'sort'=>array('_id'=>EMongoCriteria::SORT_DESC),
		);
		return  UserEventModel::model()->findAll($criteria);
	}
}
