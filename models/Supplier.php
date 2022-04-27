<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property string $t_status
 */
class Supplier extends \yii\db\ActiveRecord
{
    public $field;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['t_status'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['code'], 'string', 'max' => 3],
            [['code'], 'unique'],
            [['field'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public  function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'code' => '编码',
            't_status' => '状态',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public  function attributeLabelMap()
    {
        return [
            ['key'=>"id","val"=>"Id"],
            ['key'=>"name","val"=>"名称"],
            ['key'=>"code","val"=>"编码"],
            ['key'=>"t_status","val"=>"状态"],
        ];
    }

    /**
     * {@inheritdoc}
     * @return SupplierQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SupplierQuery(get_called_class());
    }
}
