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
    </p>

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'showFooter' => true,//是否显示表格尾部
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
                'footer' => '<a class="btn btn-danger" onclick=rankedexport("/basic/web/?r=supplier/export")>导出选中数据</a>',//设置该列底部内容
               //'footerOptions' => ['colspan' => 5,'class'=>'hide'],
            ],
            ['attribute' => 'id', 'footerOptions' => ['class'=>'hide']],
            ['attribute' => 'name', 'footerOptions' => ['class'=>'hide']],
            ['attribute' => 'code', 'footerOptions' => ['class'=>'hide']],
            ['attribute' => 't_status', 'footerOptions' => ['class'=>'hide']],
        ],
        'layout'=> '{items} '."\n".' {summary}'."\n".' {pager}',
    ]);

    ?>
    <script>
        //导出记录
        function downloadFile(data,name){
            if (!data) {
                console.log('下载失败，解析数据为空！')
                return
            }
            // 创建一个新的url，此url指向新建的Blob对象
            let url = 'data:text/csv;charset=utf-8,\ufeff' + encodeURIComponent(data);
            // 创建a标签，并隐藏改a标签
            let link = document.createElement('a')
            link.style.display = 'none'
            // a标签的href属性指定下载链接
            link.href = url
            //setAttribute() 方法添加指定的属性，并为其赋指定的值。
            link.setAttribute('download', name + '.csv')
            document.body.appendChild(link)
            link.click()
        }
        function rankedexport(url) {
            var ckbox = $('input[name="selection[]"]:checked'), ids = [];
            $.each(ckbox, function(i, o) {
                ids.push(o.value);
            });
            if(ids.length <= 0) return alert('请至少选择一条数据！');

            var okay = confirm('此操作将导出选中的数据，是否确认操作？');
            if(!okay) return;
            ids = ids.join(',');
            $.ajax({
                url: url,
                type: "post",
                data:"ids="+ids,
                responseType: 'blob',
                success: function(result){
                    console.log(result)
                    var timestamp = Date.parse(new Date());
                   var csv= "厂商-"+timestampToTime(timestamp)
                    downloadFile(result,csv)
                }
            });
        }
        function timestampToTime(timestamp) {
            var date = new Date();
            var Y = date.getFullYear() ;
            var M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1):date.getMonth()+1);
            var D = (date.getDate()< 10 ? '0'+date.getDate():date.getDate());
            var h = (date.getHours() < 10 ? '0'+date.getHours():date.getHours());
            var m = (date.getMinutes() < 10 ? '0'+date.getMinutes():date.getMinutes()) ;
            var s = date.getSeconds() < 10 ? '0'+date.getSeconds():date.getSeconds();
            return Y+M+D+h+m+s;
        }
    </script>
</div>
