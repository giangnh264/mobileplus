<?php
Yii::import('application.modules.gamification.models._base.BaseEventModel');
class EventModel extends BaseEventModel
{
    const _ACTIVE=1;
    const _DE_ACTIVE=0;

    const _E_PLAY_SONG          = '55fbbd1786dbdf86628b4567';
    const _E_DOWNLOAD_SONG      = '5551e6f4037995f80a000029';
    const _E_PLAY_VIDEO         = '55ffc76685dbdf485d8b4567';
    const _E_DOWNLOAD_VIDEO     = '5562892ed665c0ac1ee6aeef';
    const _E_SUBSCRIBE_EXT_A1   = '55ffc7e785dbdfd06e8b4567';
    const _E_SUBSCRIBE_EXT_A7   = '55ffc80c85dbdfcd268b4567';
    const _E_SUBSCRIBE_A1       = '55ffc7e785dbdfd06e8b4567';
    const _E_SUBSCRIBE_A7       = '55ffc7f585dbdfc80f8b4567';
    const _E_SUBSCRIBE_EXT_RETRY_A7_4K       = '5608a1a085dbdfb13b8b4567';
    const _E_SUBSCRIBE_EXT_RETRY_A7_3K       = '5608a1b385dbdf89448b4567';
    const _E_PLAY_ALBUM     = '560a3e9d86dbdf6c0f8b4567';

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function beforeSave()
    {
        if(parent::beforeSave())
        {
            $this->status = (int) $this->status;
            $this->reset = (int) $this->reset;
            $this->point = (int) $this->point;
            $this->created_by = (int) $this->created_by;
            $this->updated_by = (int) $this->updated_by;
            return true;
        }
        else return false;
    }
}