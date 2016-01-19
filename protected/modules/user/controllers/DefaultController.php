<?php

class DefaultController extends Controller
{
    public function init()
    {
        ini_set('max_execution_time', 7200);
        ini_set("memory_limit", "1224M");
        $this->pageTitle = "Đăng ký hủy tập thuê bao";
        parent::init();
    }

    public function actionIndex()
    {
        $model = new ImportUserFileModel ('search');
        $model->unsetAttributes(); // clear any default values

        $this->render('index', array(
            'model' => $model
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new ImportUserFileModel();
        $content_type = Yii::app()->request->getParam('content_type', 'subscribe');
        Yii::app()->session['content_type'] = $content_type;
        if (Yii::app()->request->isPostRequest) {
            $content_type = Yii::app()->session['content_type'];
            $package_id = Yii::app()->request->getParam('package_id', null);
            if(!isset($package_id))
                $model->addError ( "name", "Chưa chọn gói cước!" );
            if (!$_FILES ['file'] ['error']) {
                $ext = Utils::getExtension($_FILES ['file'] ['name']);
                $type = $_FILES ['file'] ['type'];
                if ($ext == 'xls' && ($type == 'application/xls' || $type == 'application/vnd.ms-excel')) {
                    $storage = Yii::app()->params ['storage'] ['baseStorage'] . "uploads" . DS . "user" . DS;
                    Utils::makeDir($storage);
                    $fileName = $_FILES ['file'] ['name'];
                    if (move_uploaded_file($_FILES ['file'] ['tmp_name'], $storage . DS . $fileName)) {
                        $transaction = Yii::app()->db->beginTransaction();
                        try {
                            $file_path = $storage . DS . $fileName;
                            $model->file_name = $fileName;
                            $model->created_by = $this->userId;
                            $model->file_path = $file_path;
                            $model->package_id = $package_id;
                            $model->created_time = new CDbExpression ("NOW()");
                            $model->content_type = $content_type;
                            if ($model->save(false)) {
                                $data = new ExcelReader ($file_path);
                                $start_row = 2;
                                $limit_row = $data->rowcount();
                                $cell_name = "A";
                                $arrayVal = array();
                                for ($i = $start_row; $i <= $limit_row; $i++) {
                                    if ($data->val($i, $cell_name) == "") {
                                        continue;
                                    }
                                    $name = $model->my_encoding($data->val($i, $cell_name));
                                    $arrayVal [] = "('$name','{$model->id}','$package_id')";
                                }
                                /**
                                 * Start insert here: split 200 line per command
                                 */
                                $arrs = array_chunk($arrayVal, 200);
                                foreach ($arrs as $arr) {
                                    $vals = implode(",", $arr);
                                    $sql = "INSERT INTO import_user_content (`msisdn`,`file_id`,`package_id`) VALUES $vals";
                                    $command = Yii::app()->db->createCommand($sql);
                                    $command->execute();
                                }

                                $transaction->commit();
                                $this->redirect(array(
                                    'view',
                                    'id' => $model->id,'content_type'=>$content_type

                                ));
                            } else {
                                $transaction->rollback();
                            }
                        } catch (Exception $e) {
                            $transaction->rollback();
                            $model->addError("exception", $e->getMessage());
                        }
                    } else {
                        $model->addError("name", "Không upload được file vào thư mục:" . $storage . DS . $fileName);
                    }
                } else {
                    $model->addError("name", "Chỉ upload file xls");
                }
            } else {
                $model->addError("name", "Chưa upload file");
//                $model->content_type = $content_type;
            }
        }
        $this->render('create', array(
            'model' => $model,
            'content_type'=>$content_type
        ));
    }

    /**
     * Displays a particular model.
     *
     * @param integer $id
     *            the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $content_type = Yii::app()->request->getParam('content_type', 'subscribe');
        $count = ImportUserContentModel::model()->getCount($id);
        $page = new CPagination($count);
        $page->pageSize = 100;

        $songs = ImportUserContentModel::model()->getList($id, $page->getLimit(), $page->getOffset());
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'songs' => $songs,
            'page' => $page,
            'content_type'=>$content_type
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     *
     * @param integer $id
     *            the ID of the model to be loaded
     * @return CopyrightSongFileModel the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = ImportUserFileModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException (404, 'The requested page does not exist.');
        return $model;
    }


    public function actionSet()
    {
        $cids = Yii::app()->request->getParam('cid');
        $page = Yii::app()->request->getParam('page');
        $fileId = Yii::app()->request->getParam('fileId');
        $sql = "SELECT t1.*, t2.* FROM import_user_content t1
                LEFT JOIN import_user_file t2 ON t1.file_id = t2.id
                WHERE t1.file_id = :FID";
        $dataCmd = Yii::app()->db->createCommand($sql);
        $dataCmd->bindParam(":FID", $fileId, PDO::PARAM_INT);
        $dataList = $dataCmd->queryAll();
        foreach ($dataList as $item) {
            //dk cho tap thue bao
            $phone = Formatter::formatPhone($item['msisdn']);
            $data= Yii::app()->request->getParam('data','');
            $package = PackageModel::model()->findByPk($item['package_id']);
            $packageCode = $package->code;
            $packageCode = trim($packageCode);
            $bmUrl = yii::app()->params['bmConfig']['remote_wsdl'];
            $client = new SoapClient($bmUrl, array('trace' => 1));
            if($item['content_type'] == 'subscribe'){
                $params = array(
                    'phone' => $phone,
                    'package' => $packageCode,
                    'source' => 'cskh',
                    'promotion' => 0,
                    'bundle' => 0,
                    'smsId'=>null,
                    'note_event'=>'',
                );
                $rt = $client->__soapCall('userRegister', $params);
            }else{
                //huy
                $params = array(
                    'user_id' => 0,
                    'user_phone' => $phone,
                    'package' => $packageCode,
                    'source' => 'cskh',
                );
                $rt = $client->__soapCall('userUnRegister', $params);
            }
            if ($rt->errorCode == 0) {
                $status = 1;
            } else {
                $status = 0;
            }

            $model = ImportUserContentModel::model()->findByAttributes(array('msisdn'=>$phone,'package_id'=>$item['package_id']));
            $model->status = $status;
            $model->return_code = $rt->errorCode;
            $model->save(false);
            //
        }
        $this->redirect(array('view', 'id' => $fileId, 'page' => $page));
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        if ($model->delete()) {
            SetPriceContentModel::model()->deleteAll('file_id = :ID', array(':ID' => $id));
        }

    }

    public function actionDeleteItem()
    {
        $id = Yii::app()->request->getParam('id');
        $file_id = Yii::app()->request->getParam('fileId');
        $model = SetPriceContentModel::model()->findbyPk($id);
        $model->delete();
        $this->redirect(array('view', 'id' => $file_id));
    }
}
