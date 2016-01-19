<?php $this->beginContent('application.views.web.layouts.main'); ?>
<div class="colum1 fll">
    <!--main content-->
    <?php echo $content;?>
</div>
<div class="colum2 flr">
    <!--sidebar right-->
    <?php echo $this->clips['sidebar-r'];?>
</div>
<?php $this->endContent(); ?>