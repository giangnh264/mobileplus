<?php

class ProductController extends Controller
{

    public $coverWidth = 570;
    public $coverHeight = 340;
    public function init()
	{
            parent::init();
            $this->pageTitle = Yii::t('admin', "Quản lý Product ") ;
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);

		$model=new ProductModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ProductModel']))
			$model->attributes=$_GET['ProductModel'];

		$this->render('index',array(
			'model'=>$model,
            'pageSize'=>$pageSize
		));
	}
	
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
		$model=new ProductModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ProductModel']))
		{
            var_dump($_FILES);
            $model->attributes=$_POST['ProductModel'];
			if($model->save()){
                $number = (int) $_POST ["number"];
                for($i=1 ; $i <= $number; $i++){
                    echo "<pre>";
                    var_dump($_FILES["clip_thumbnail_2"]);
                    echo "<pre>";

                    /*if ($_FILES["clip_thumbnail_$i"]['size'] > 0) {
                        $coverPath = $this->uploadFile($_FILES["clip_thumbnail_$i"], $model, $i);
                        $product_img = new ProductImgModel();
                        $product_img->product_id = $model->id;
                        $product_img->img_url = $coverPath;
                        $product_img->created_time = date('Y-m-d H:i:s');
                        $product_img->status = 1;
                        $product_img->sorder = 0;
                        $res = $product_img->save();
                        if(!$coverPath){
                            $model->addError('cover', 'Cover should more '.$this->coverWidth."x".$this->coverHeight);
                        }
                    }*/
                }
                exit;
            }
               /* if ($_FILES['clip_thumbnail']['size'] > 0) {
                    $coverPath = $this->uploadFile($_FILES['clip_thumbnail'], $model);
                    $product_img = new ProductImgModel();
                    $product_img->product_id = $model->id;
                    $product_img->img_url = $coverPath;
                    $product_img->created_time = date('Y-m-d H:i:s');
                    $product_img->status = 1;
                    $product_img->sorder = 0;
                    $res = $product_img->save();
                    if(!$coverPath){
                        $model->addError('cover', 'Cover should more '.$this->coverWidth."x".$this->coverHeight);
//                    goto cIteratorExit;
                    }
                }*/
				$this->redirect(array('view','id'=>$model->id));
		}
//        cIteratorExit;
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

		if(isset($_POST['ProductModel']))
		{
			$model->attributes=$_POST['ProductModel'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

                /**
	 * Copy record
	 * If copy is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be copy
	 */
	public function actionCopy($id)
	{
		$data = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ProductModel']))
		{
                        $model=new ProductModel;
			$model->attributes=$_POST['ProductModel'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('copy',array(
			'model'=>$data,
		));
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
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
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	/**
    * bulk Action.
    * @param string the action
    */
    public function actionBulk() {
    	$act = Yii::app()->request->getParam('bulk_action', null);
        if (isset($act) &&  $act != "") {
        	$this->forward($this->getId()."/" . $act);
        }else {
        	$this->redirect(array('index'));
        }
	}

    /**
    * Delete all record Action.
    * @param string the action
    */
    public function actionDeleteAll() {           
    	if(isset($_POST['all-item'])){
        	ProductModel::model()->deleteAll();
        }else{
        	$item = $_POST['cid'];
            $c =  new CDbCriteria;
            $c->condition = ('id in ('.implode($item, ",").')');
            $c->params = null;
			ProductModel::model()->deleteAll($c);
		}
        $this->redirect(array('index'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ProductModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='product-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionLoadmore(){
		$id = (int) Yii::app()->request->getParam('id', null);
		$id = $id + 1;
		$this->renderPartial ( "_loadmore", compact ( "id") );
		Yii::app ()->end ();
	}

    /**
     * upload file
     */
    protected function uploadFile($file, $model, $i) {
        $coverPath = "";
        $fileSystem = new Filesystem();
        if (isset($file['error']) && $file['error'] == 0) {
            $ext = explode('.', $file['name']);
            $extFile = $ext[count($ext) - 1];
            $id = $model->id;
            $srcFileName = $id . time() . "." . $extFile;
            $tmpPath = Yii::app()->getRuntimePath();

            $fileDesPath = $tmpPath . DIRECTORY_SEPARATOR . $srcFileName;
            try {
                if (move_uploaded_file($file['tmp_name'], $fileDesPath)) {
                    list($width, $height) = getimagesize($fileDesPath);
                    if($width < $this->coverWidth || $height < $this->coverHeight){
                        return false;
                    }
                    $imgCrop = new ImageCrop($fileDesPath, 0, 0, $width, $height);
                    $coverPath = $model->getCoverUrl($model->id, $i);
                    Utils::makeDir(dirname($coverPath));
                    $imgCrop->resizeCrop($coverPath, $this->coverWidth, $this->coverHeight, 100);

                    unlink($fileDesPath);
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        return $coverPath;
    }
}
