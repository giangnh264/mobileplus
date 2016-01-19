<div style="padding: 10px;">
    <?php if ($package): ?>
        <div class="padB10">
            <div class="padL10 padT10 fontB">
                <?php echo $package->name; ?>
            </div>
            <div class="padT10 padL10">
                <?php
                if ($this->isPromotion) {
                    $model = ConfigModel::model()->findByPk(1);
                    echo $model->value;
                } else {
                    echo $package->description;
                }
                ?>
            </div>
        </div>
        <div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'action' => Yii::app()->baseUrl . '/account/doRegister',
                'id' => 'subscribe-form',
                'enableAjaxValidation' => false,
            ));
            ?>
            <?php echo CHtml::hiddenField('phoneNumber', '') ?>
            <?php echo CHtml::hiddenField('id', $package->id) ?>
            <div class="padL10 padT10 padB10">
                <div style="width: 60%; float: left">
                    <?php echo CHtml::submitButton(Yii::t('chachawap', 'ĐĂNG KÝ'), array('class' => 'btnRed')); ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    <?php else: ?>
        <p>Không tồn tại gói cước này.</p>
    <?php endif; ?>
</div>