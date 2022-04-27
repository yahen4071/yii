<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $model app\models\Supplier */


$this->title = 'Suppliers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form=ActiveForm::begin()?>
    <?php
    $options = \yii\helpers\ArrayHelper::map($model->attributeLabelMap(), 'key', 'val');
    echo $form->field($model, 'field')->checkboxList($options,['value'=>["id"],'class' => CheckboxColumn::className()]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('导出所有数据', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end();?>
</div>
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
        var ckbox = $('input[name="Supplier[complains_field][]"]:checked'), ids = [];
        $.each(ckbox, function(i, o) {
            ids.push(o.value);
        });
        if(ids.length <= 0) return alert('请至少选择一条数据！');

        var okay = confirm('此操作将导出选中的数据，是否确认操作？');
        if(!okay) return;
        ids = ids.join(',');
        alert(url)
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