<?php

use modava\slide\widgets\NavbarWidgets;
use yii\helpers\Html;
use yii\helpers\Url;
use modava\slide\SlideModule;

/* @var $this yii\web\View */
/* @var $model modava\slide\models\SlideCategory */

$this->title = SlideModule::t('slide', 'Update : {name}', [
    'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => SlideModule::t('slide', 'Slide Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = SlideModule::t('slide', 'Update');
?>
<div class="container-fluid px-xxl-25 px-xl-10">
    <?= NavbarWidgets::widget(); ?>

    <!-- Title -->
    <div class="hk-pg-header">
        <h4 class="hk-pg-title"><span class="pg-title-icon"><span
                        class="ion ion-md-apps"></span></span><?= Html::encode($this->title) ?>
        </h4>
        <a class="btn btn-outline-light" href="<?= Url::to(['create']); ?>"
           title="<?= SlideModule::t('slide', 'Create'); ?>">
            <i class="fa fa-plus"></i> <?= SlideModule::t('slide', 'Create'); ?></a>
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>

            </section>
        </div>
    </div>
</div>
