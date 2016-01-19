<fieldset>
<div class="view">
    <p>
    <b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
    <?php echo CHtml::encode($data->user_id); ?>
    </p>
    <p>
    <b><?php echo CHtml::encode($data->getAttributeLabel('user_phone')); ?>:</b>
    <?php echo CHtml::encode($data->user_phone); ?>
    </p>
    <p>
        <b><?php echo CHtml::encode($data->getAttributeLabel('content_id')); ?>:</b>
        <?php echo CHtml::encode($data->content_id); ?>
    </p>
    <p>
        <b><?php echo CHtml::encode($data->getAttributeLabel('content_name')); ?>:</b>
        <?php echo CHtml::encode($data->content_name); ?>
    </p>
    <p>
    <b><?php echo CHtml::encode($data->getAttributeLabel('event_id')); ?>:</b>
    <?php echo CHtml::encode($data->event_id); ?>
    </p>
    <p>
    <b><?php echo CHtml::encode($data->getAttributeLabel('event_name')); ?>:</b>
    <?php echo CHtml::encode($data->event_name); ?>
    </p>
    <p>
        <b><?php echo CHtml::encode($data->getAttributeLabel('group_id')); ?>:</b>
        <?php echo CHtml::encode($data->group_id); ?>
    </p>
    <p>
        <b><?php echo CHtml::encode($data->getAttributeLabel('group_name')); ?>:</b>
        <?php echo CHtml::encode($data->group_name); ?>
    </p>
    <p>
    <b><?php echo CHtml::encode($data->getAttributeLabel('point')); ?>:</b>
    <?php echo CHtml::encode($data->point); ?>
    </p>

    <p>
    <b><?php echo CHtml::encode($data->getAttributeLabel('created_time')); ?>:</b>
    <?php echo CHtml::encode($data->created_time); ?>
    </p>

    <p>
    <b><?php echo CHtml::encode($data->getAttributeLabel('updated_time')); ?>:</b>
    <?php echo CHtml::encode($data->updated_time); ?>
    </p>
    <p>
    <b><?php echo CHtml::encode($data->getAttributeLabel('method')); ?>:</b>
    <?php echo CHtml::encode($data->method); ?>
    </p>
</div>
</fieldset>