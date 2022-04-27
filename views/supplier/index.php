<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SupplierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $checkboxColumn yii\grid\CheckboxColumn */


$this->title = 'Suppliers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Supplier', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('导出所有数据', ['export'], ['class' => 'btn btn-success',"target"=>"_blank"]) ?>
    </p>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //设置筛选模型
        'filterModel' => $searchModel,
        'showFooter' => false,//是否显示表格尾部
        'headerRowOptions' => ['class'=>'abc'],//排序行的属性
        'pager' => [//自定义分页样式以及显示内容
            'class' => '\yii\bootstrap4\LinkPager',
            'prevPageLabel'=>'上一页',
            'nextPageLabel'=>'下一页',
            'firstPageLabel' => '第一页',
            'lastPageLabel' => '最后一页',
        ],
        'columns' => [
            [
                'class' => CheckboxColumn::className(),  //复选框
              //  'footer' => '<a class="btn btn-danger" onclick=rankedexport("/basic/web/?r=supplier/export")>导出选中数据</a>',//设置该列底部内容
            ],
            ['attribute' => 'id', ],
            ['attribute' => 'name', ],
            ['attribute' => 'code',],
            ['attribute' => 't_status', 'filter' => ['ok' => 'ok','hold'=>"hold"]],
            [
                "class" => "yii\grid\ActionColumn",
                "template" => " {create} {view} {update} {delete}",
                "header" => "操作",
            ],
        ],
        'layout'=> '{items} '."\n".' {summary}'."\n".' {pager}',
    ]);

    ?>
    <div class="dataTables_paginate paging_simple_numbers">
    </div>

</div>