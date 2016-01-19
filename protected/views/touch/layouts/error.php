<?php $this->beginContent('application.views.touch.layouts._header'); ?>
<?php
$controller = Yii::app()->controller->id;
$action = Yii::app()->controller->action->id;
?>
<div id="wrr-page">
    <section class="cpage">
        <div class='container'>
            <header>
            	<div class="wrr-header">
	            <span class="ih1"></span>
	            <span class="ih2"></span>
                <a href='javascript:void(0);' class='menu-n left'></a>
                <a href='<?php echo Yii::app()->createUrl('/site') ?>' class='haslogo'><h1 class='logo-project'></h1></a>
                <form action='<?php echo Yii::app()->createUrl('/search/index'); ?>' method='get' class='frm-search-n hidden' onsubmit="return checkInput();">
                    <input type='text' name="content" id="txt-content"  placeholder="<?php echo Yii::t("wap","Search");?>" class='keyword hidden'/>
                    <button type="submit" class='search-n right' style="border: 0">&nbsp;</button>
                </form>
                </div>
            </header>
            <nav>
                <ul>
                    <li>
                        <a class="home <?php if ($controller == 'site'): ?> active<?php endif; ?>" href='<?php echo Yii::app()->createUrl('/site/index') ?>'><?php echo Yii::t("wap","Home");?></a>
                    </li>
                    <li>
                        <a class='<?php if ($controller == 'song'): ?> active<?php endif; ?>' href='<?php echo Yii::app()->createUrl('/song') ?>'><?php echo Yii::t("wap","Song");?></a>
                    </li>
                    <li>
                        <a class=' <?php if ($controller == 'video'): ?> active<?php endif; ?>' href='<?php echo Yii::app()->createUrl('/video') ?>' ><?php echo Yii::t("wap","Video");?></a>
                    </li>
                    <li>
                        <a class=' <?php if ($controller == 'album'): ?> active<?php endif; ?>' href='<?php echo Yii::app()->createUrl('/album') ?>' ><?php echo Yii::t("wap","Album");?></a>
                    </li>
                    <li>
                        <a class=' <?php if ($controller == 'bxh'): ?> active<?php endif; ?>' href='<?php echo Yii::app()->createUrl('/bxh') ?>' ><?php echo Yii::t("wap","Charts");?></a>
                    </li>
                   <!-- <li>
                        <a class=' <?php /*if ($controller == 'shell'): */?> active<?php /*endif; */?>' href='<?php /*echo Yii::app()->createUrl('/shell') */?>' ><?php /*echo Yii::t("wap","Độc quyền");*/?></a>
                    </li>-->
                </ul>
            </nav>
            <div id="adv10" class="vg_ads">
            </div>
            <div class="vg_contentBody">
                <?php if (Yii::app()->user->hasState('DK_MA_MSG')) { ?>
                    <div class="pad10"><?php echo Yii::app()->user->getState('DK_MA_MSG'); ?></div>
                    <?php
                    Yii::app()->user->setState('DK_MA_MSG', null);
                } elseif (Yii::app()->user->hasState('DK_MA_MSG_CC') && Yii::app()->user->getState('DK_MA_MSG_CC') != '') {
                    $linkRedirect = Yii::app()->user->getState('DK_MA_MSG_RL');
                    ?>
                    <div class="pad10"><?php echo Yii::app()->user->getState('DK_MA_MSG_CC'); ?></div>
                    <div class="bt-subscribe">
                        <div style="padding: 10px;">
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'action' => Yii::app()->baseUrl . '/account/unregisterPackage',
                                'id' => 'subscribe-form-CHACHAFUN',
                                'enableAjaxValidation' => false,
                            ));
                            ?>
                            <?php echo CHtml::hiddenField('package', 'CHACHAFUN') ?>
                            <table width="100%">
                                <tr>
                                    <td align="right"><?php echo CHtml::submitButton(Yii::t('chachawap', 'HỦY'), array('class' => 'button', 'style' => 'font-size: 11px;float: right; width: 90px;')); ?></td>
                                    <td width="20">&nbsp;</td>
                                    <td align="left"><?php echo CHtml::link(yii::t('chachawap', 'TRẢI NGHIỆM'), $linkRedirect, array('class' => 'button bt-actived', 'style' => 'font-size: 11px;float: left; padding-left: 10px;')) ?></td>
                                </tr>
                            </table>

                            <?php $this->endWidget(); ?>
                        </div>
                    </div>
                    <?php
                    Yii::app()->user->setState('DK_MA_MSG_CC', null);
                    Yii::app()->user->setState('DK_MA_MSG_RL', null);
                }
                ?>
                <?php echo $content; ?>
                <div id="fuccload" class="load-more-page" style="display: none"><img src="/touch/images/ajax_loading.gif" /></div>
            </div>
           
            <footer>
            	
                <ul>
                    <li><a class='<?php if ($controller == 'site' && $action == 'index'): ?> active<?php endif; ?>' href='<?php echo Yii::app()->createUrl('/site/index'); ?>'><?php echo Yii::t("wap","Home");?></a></li>
                    <li>|</li>
                    <li><a class='<?php if ($controller == 'account' && $action == 'guide'): ?> active<?php endif; ?>' href='<?php echo Yii::app()->createUrl('/account/guide', array('id' => 7)) ?>'><?php echo Yii::t("wap","Giới thiệu");?></a></li>
                    <li>|</li>
                    <!--<li><a class='<?php /*if ($controller == 'account' && $action == 'guide'): */?> active<?php /*endif; */?>' href='<?php /*echo Yii::app()->createUrl('/account/downloadApp') */?>'><?php /*echo Yii::t("wap","Tải ứng dụng");*/?></a></li>-->
                    <?php /*
                      <li><a class='<?php if($controller=='site' && $action=='appDownload'):?> active<?php endif;?>' href='<?php echo Yii::app()->createUrl('/site/appDownload');?>'>Tải ứng dụng</a></li>
                     */ ?>
                    <li>
                        <a href='#top' id='gotop'>
                            <span class='ic-top'></span>
                            Top
                        </a>
                    </li>
                </ul>
                <div class="copyright">
                    <p><?php echo Yii::t('wap','Copyright © 2015 MobiFone. All rights reserved')?></p>
                </div>
                <div class="end_menusite">
                    <p><?php echo Yii::t('wap','Cơ quan chủ quản: Công ty cổ phần Bạch Minh (VEGA Corporation)');?></p>
                    <p><?php echo Yii::t('wap','Địa chỉ: P804, tầng 8, tòa nhà V.E.T, 98 Hoàng Quốc Việt, Nghĩa Đô, Cầu Giấy, Hà Nội.');?></p>
                    <p><?php echo Yii::t('wap','DKKD: 0101380911 do Sở KHDT Hà Nội cấp 20/6/2003');?></p>
                    <p><?php echo Yii::t('wap','Email: info@vega.com.vn');?></p>
                    <p><?php echo Yii::t('wap','Tel: 04 37554190');?></p>
                    <p><?php echo Yii::t('wap','Người chịu trách nhiệm nội dung: Bà Nguyễn Thu Dung');?></p>
                </div>
            </footer>
        </div><!-- End .container-->
    </section><!-- End .cpage-->
    <?php include_once '_menu_side.php'; ?>

</div>
<?php $this->endContent(); ?>

