<?php
class MusicLogger
{
    const DEBUG = 1;    // Most Verbose
    const INFO = 2;    // ...
    const WARN = 3;    // ...
    const ERROR = 4;    // ...
    const FATAL = 5;    // Least Verbose
    const OFF = 6;    // Nothing at all.

    const LOG_OPEN = 1;
    const OPEN_FAILED = 2;
    const LOG_CLOSED = 3;

    const _STORAGE = '/u01/storage/amusic/logs';
//    const _STORAGE = 'E:\Vega//';

    /* Public members: Not so much of an example of encapsulation, but that's okay. */
    public $Log_Status = self::LOG_CLOSED;
    public $DateFormat = "Y-m-d H:i:s";
    public $MessageQueue;

    private $log_file;
    private $priority = self::INFO;

    private $file_handle;

    public function __construct($priority)
    {
        if ($priority == self::OFF) return;
        $this->priority = $priority;

        return;
    }

    public function __destruct()
    {
        if ($this->file_handle)
            fclose($this->file_handle);
    }
    public function setFilePathLog($fileName){
        $storagePath = self::_STORAGE;
        $fileName = empty($fileName) ? "log" : $fileName;
        $fileName .= '_' . date('Ymd');
        $path = $storagePath . DS . $fileName . ".log";
        $this->log_file = $path;

        $this->MessageQueue = array();

        if (file_exists($this->log_file)) {
            if (!is_writable($this->log_file)) {
                $this->Log_Status = self::OPEN_FAILED;
                $this->MessageQueue[] = "The file exists, but could not be opened for writing. Check that appropriate permissions have been set.";
                return;
            }
        }

        $this->file_handle = fopen($this->log_file, 'a');
        if ($this->file_handle) {
            $this->Log_Status = self::LOG_OPEN;
            $this->MessageQueue[] = "The log file was opened successfully.";
        } else {
            $this->Log_Status = self::OPEN_FAILED;
            $this->MessageQueue[] = "The file could not be opened. Check permissions.";
        }
    }
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }
    private function parseParams($params)
    {
        switch($params["cmd"])
        {
            case 'play_song':
            case 'download_song':
            case 'play_video':
            case 'download_video':
            case 'play_album':
                $data = $this->logContent($params);
                $data = implode('|',$data);
                break;
            case 'subscribe':
            case 'unsubscribe':
                $data = $this->logMsisdn($params);
                $data = implode('|',$data);
                break;
            default:
                $data = false;
                break;
        }
        $data = $data . '|';
        return $data;
    }
    
    public function generateLog($params){
        $line = $this->parseParams($params);
        if(!empty($line)) {
            $this->Log($line, $this->priority);
        }
    }

    /**
     * log noi dung
     */
    public function logContent($params)
    {
        $this->setFilePathLog('content_log');
        $data = array();
        $data['channel']=!empty($params["source"])?$params["source"]:'NA';
        $data['network_type'] = Yii::app()->user->getState('is3G')?'3g':'wifi';
        $data['user_id'] = $params["msisdn"];
        $data['package_id'] = isset($params['packageId'])? $params['packageId']: '0';
        if($params['packageId']>0){
            $package = PackageModel::model()->findByPk($params['packageId']);
            $packageName = $package?$package->name:"NA";
        }else{
            $packageName = 'NA';
        }
        $data['package_name'] = $packageName;
        $data['action'] = $params["cmd"];
        $data['price'] = $params["price"];
        $data['content_id'] = isset($params['obj1_id'])? $params['obj1_id']: '0';
        $data['content_name'] = isset($params['obj1_name'])? $params['obj1_name']: 'NA';
        $data['content_type'] = $params["cmd"];
        $data['part_id'] = ($params["cmd"]=='play_album')?$params['obj2_id']:'0';
        $data['category_id'] = !empty($params['genre_id'])?$params['genre_id']:0;
        $data['category_name'] = "NA";
        if($params['genre_id']>0){
            $genre = GenreModel::model()->findByPk($params['genre_id']);
            if($genre){
                $data['category_name'] = $genre->name;
            }
        }
        $data['cp_id'] = '0';

        $data['cp_name'] = 'NA';
        return $data;
    }

    public function logCharging($params)
    {
        $this->setFilePathLog('charging_log');
        $data = array();
        $data['channel']=!empty($params["source"])?$params["source"]:'NA';
        $data['user_id'] = $params["msisdn"];
        //$data['package_id'] = isset($params['packageId'])? $params['packageId']: '0';
        $data['action'] = $params["cmd"];
        $data['price'] = $params["price"];
        $data['request_time'] = $params["request_time"];
        $data['response_time'] = $params["response_time"];
        $data['error_code'] = $params["error_code"];
        $data['error_mesage'] = $params["error_mesage"];
        //$data = $params;
        $line = implode('|',$data);
        $line = $line . '|';
        if(!empty($line)) {
            $this->Log($line, $this->priority);
        }
    }
    /**
     * log gia han
     */
    public function logMonfee($params)
    {
        $this->setFilePathLog('monfee_log');
        $data = array();
        $data['channel']=!empty($params["source"])?$params["source"]:'NA';
        $data['user_id'] = $params["msisdn"];
        $data['package_id'] = isset($params['packageId'])? $params['packageId']: '0';
        $data['package_name'] = $params['packageName'];
        $data['expired_time'] = isset($params['expired_time'])? $params['expired_time']: 'NA';
        $data['action'] = 'monfee';
        $data['retry_count_inday'] = isset($params["retry_count_inday"])?$params["retry_count_inday"]:'NA';
        $data['retry_count'] = isset($params["retry_count"])?$params["retry_count"]:"NA";
        $data['price'] = $params["price"];
        $data['request_time'] = $params["createdDatetime"];
        $data['response_time'] = $params["createdDatetime"];
        $data['error_code'] = $params['return_code'];
        $errorMsg = array(
            0=>'Success',
            1=>'Balance too low',
            6=>'Msisdn not exists'
        );
        $data['error_mesage'] = array_key_exists($params["return_code"],$errorMsg)?$errorMsg[$params["return_code"]]:"NA";

        $line = implode('|',$data);
        $line = $line . '|';
        if(!empty($line)) {
            $this->Log($line, $this->priority);
        }

    }
    /**
     * log thuê bao
     */
    public function logMsisdn($params)
    {
        $this->setFilePathLog('sub_log');
        $data = array();
        $data['channel']=!empty($params["source"])?$params["source"]:'NA';
        $data['user_id'] = $params["msisdn"];
        $data['package_id'] = isset($params['packageId'])? $params['packageId']: '0';
        if($params['packageId']>0){
            $package = PackageModel::model()->findByPk($params['packageId']);
            $packageName = $package?$package->name:"NA";
        }else{
            $packageName = 'NA';
        }
        $data['package_name'] = $packageName;
        $data['action'] = $params["cmd"];
        $data['price'] = $params["price"];
        $data['source'] = ($params['note'] != '')? '"' . $params["note"] . '"' : NULL;
        $data['cp_id'] = isset($params['cp_id'])? $params['cp_id']: '0';
        if($params['cp_id']>0){
            $cp = CpModel::model()->findByPk($params['cp_id']);
            $cpName = $cp?$cp->name:"NA";
        }else{
            $cpName = 'NA';
        }
        $data['cp_name'] = $cpName;
        return $data;
    }

    /**
     * Log truy cập
     */
    public function logVisit($line)
    {
        $this->setFilePathLog('access_log');
        if(!empty($line)){
            $this->Log($line, $this->priority);
        }

    }

    /**
     * Log tin nhắn
     */
    public function logSms($params){
        $action = 'NA';
        switch (strtoupper($params['action'])){
            case 'MK':
                $action = 'password';
                break;
            case 'HUY A1':
            case 'HUY A7':
            $action = 'cancel';
                break;
            case 'GIA':
                $action = 'price';
                break;
            case 'KT':
                $action = 'check';
                break;
            case 'DK A1':
            case 'DK A7':
                $action = 'subscribe';
                break;
            case 'TROGIUP':
            case 'HELP':
            case 'TG':
                $action = 'help';
                break;
        }
        $this->setFilePathLog('sms_log');
        $data = array();
        $data['channel']=!empty($params["channel"])?$params["channel"]:'{}';
        $data['msisdn'] = $params["msisdn"];
        $data['action'] = $action;
        $data['method'] = $params['method'];
        $data['mo_receive_time'] = isset($params['mo_receive_time'])? $params['mo_receive_time']: 'NA';
        $data['mt_sent_time'] = isset($params['mt_sent_time'])? $params['mt_sent_time']: 'NA';
        $data['process_time'] = isset($params['process_time'])? $params['process_time']: 'NA';
        $data['mo_content'] = '"' . $params["mo_content"] . '"';
        $data['mt_content'] = '"' . $params["mt_content"] . '"';
        $data['service_number'] = $params["service_number"];
        $data['params'] =isset($params['params'])? $params['params']: '{}';

        $line = implode('|',$data);
        if(!empty($line)) {
            $this->Log($line, $this->priority);
        }
    }
    private function Log($line, $priority)
    {
        if ( $this->priority <= $priority )
        {
            $status = $this->getTimeLine( $priority );
            $this->WriteFreeFormLine ( "$status [$line]"."\n" );
        }
    }

    private function WriteFreeFormLine( $line )
    {
        if ( $this->Log_Status == KLogger::LOG_OPEN && $this->priority != KLogger::OFF )
        {
            if (fwrite( $this->file_handle , $line ) === false) {
                $this->MessageQueue[] = "The file could not be written to. Check that appropriate permissions have been set.";
            }
        }
    }

    private function getTimeLine( $level )
    {
        $time = date( $this->DateFormat );
        $time = date(DATE_ISO8601, strtotime($time));
        switch( $level )
        {
            case KLogger::INFO:
                return "[$time] [INFO]";
            case KLogger::WARN:
                return "[$time] [WARN]";
            case KLogger::DEBUG:
                return "[$time] [DEBUG]";
            case KLogger::ERROR:
                return "[$time] [ERROR]";
            case KLogger::FATAL:
                return "[$time] [FATAL]";
            default:
                return "[$time] [LOG]";
        }
    }
}