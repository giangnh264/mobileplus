<?php

class DefaultController extends CController
{
	public function actionIndex()
	{
		$this->render('index');
	}
    public function actionLab()
    {
        $m = new MongoClient('mongodb://10.0.9.194:27017');
        $db = $m->music_game;
        $db = new EMongoCriteria();
        $collection = new MongoCollection($db, 'event');
        // search for fruits
        $fruitQuery = array('status' => 1);
        // search for documents where 5 < x < 20
        $rangeQuery = array('updated_time' => array( '$gt' => '2015-05-01', '$lt' => '2015-05-09' ));
        $where = array( '$and' => array( array('status' =>1), array('updated_by'=>604) ) );
        $cursor = $collection->find($where);
        echo '<pre>';print_r($cursor);
        $array = iterator_to_array($cursor);
        echo '<pre>';print_r($array);exit;
        foreach ($cursor as $doc) {
            echo '<pre>';print_r($doc);
        }
        exit;
    }
    public function actionRaw()
    {
        $limit = Yii::app()->request->getParam('limit',30000);
        $page = Yii::app()->request->getParam('page',1);
        $limit = (int) $limit;
        $page = (int) $page;
        $offset = ($page-1)*$limit;

        try {
            $connectString = Yii::app()->mongodb->connectionString;
            $m = new MongoClient("$connectString");
            $c = $m->selectDB("music_game")->selectCollection("user_event");

            $cond = array(
                array(
                    '$group' => array(
                        "_id" => array("user_phone" => '$user_phone'),
                        "total" => array('$sum' => '$point'),
                    ),
                ),
                array(
                    '$match' => array('total' => array('$gt' => 0)),
                ),
            );
            $res = $c->aggregate($cond);
            $userPhoneCount = count($res['result']);

            $posTo = $limit+$offset;
            if($posTo>=$userPhoneCount){
                $posTo = $userPhoneCount;
                //$posTo = 275000;
            }
            $posFrom = $offset;
            /*echo '$posTo:'.$posTo;
            echo '$posFrom:'.$posFrom;exit;*/
            $ops = array(
                /*array(
                    '$project' => array(
                        "_id"=>0,
                        "event_id" => 1,
                        "event_name" => 1,
                        "user_phone" => 1,
                    )
                ),*/
                array(
                    '$group' => array(
                        "_id" => array("user_phone" => '$user_phone'),
                        "total" => array('$sum' => '$point'),
                    ),
                ),
                array(
                    '$match' => array('total' => array('$gt' => 0)),
                ),
                array(
                    '$sort' => array("total" => -1),
                ),
                array(
                    '$limit' => $posTo
                ),
                array(
                    '$skip' => $posFrom
                )
            );
            $results = $c->aggregate($ops);
            echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
            echo '<h1>Log User Gamification</h1>';
            echo '<p>Page Size: ' . $limit . '</p>';
            echo '<p>Total: ' . $userPhoneCount . '</p>';
            echo '<p>Pos_From: ' . $posFrom . '</p>';
            echo '<p>Pos_To: ' . $posTo . '</p>';
            if ($results) {
                $numberPage = (int) ceil($userPhoneCount / $limit);
                $paging = array();
                $pagingExport = array();
                for ($i = 1; $i <= $numberPage; $i++) {
                    $link = Yii::app()->createUrl('/gamification/default/raw', array('page' => $i, 'limit' => $limit));
                    $linkExport = Yii::app()->createUrl('/gamification/default/raw', array('page' => $i,'limit'=>$limit,'export'=>'1'));
                    $paging[] = '<a href="' . $link . '">' . $i . '</a>';
                    $pagingExport[] = '<a href="' . $linkExport . '">Export_' . $i . '</a>';
                }
                echo implode('  ', $paging);
                echo '<br /><br />';
                echo implode('  ', $pagingExport);
                echo '<br /><br />';
                if (isset($_GET['export']) && $_GET['export'] == 1) {
                    $fileName = "Report_Gami_" . $posFrom . "_" . $posTo;
                    header('Content-type: application/v.nd.ms-excel');
                    header("Content-Disposition: attachment; filename=$fileName.xls");
                    header("Pragma: no-cache");
                    header("Expires: 0");
                }
                echo '<table border="1" rules="all" cellpadding="5">
                    <tr><th>User Phone</th><th>Điểm</th></tr>';
                foreach ($results['result'] as $key => $value) {
                    echo '<tr>';
                    echo '<th>' . $value['_id']['user_phone'] . '</th>';
                    echo '<th>' . $value['total'] . '</th>';
                    echo '</tr>';
                }
                echo '</table>';
            }
        }catch (Exception $e)
        {
            echo $e->getMessage();
        }
        //echo '<pre>';print_r($results);
    }
}