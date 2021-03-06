<?php

namespace app\controllers;

use app\models\Supplier;
use app\models\SupplierSearch;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use m35\thecsv\theCsv;


/**
 * SupplierController implements the CRUD actions for Supplier model.
 */
class SupplierController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Supplier models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SupplierSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Supplier model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    /**
     * Displays a single Supplier model.
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionExport()
    {
        $model = new Supplier();
        if ($this->request->isPost) {
            $fields =\Yii::$app->request->post('Supplier');
            $efields=['id', 'name', 'code', 't_status'];
            $labels= $model->attributeLabels();
            if (is_array($fields["field"])){
               $field=implode(",",$fields["field"]);
               $efields=$fields["field"];
               foreach ($efields as $k=>$v){
                   $header[$k]=$labels[$v];
               }
            }else{
                $field="*";
                $header= ['Id', '??????', '??????', '??????'];
            }
            $sql = "SELECT " . $field . " FROM supplier";
            theCsv::export([
                'reader' => \Yii::$app->getDb()->createCommand($sql)->query(),
                'fields' => $efields,
                'header' => $header,
                "name"=>"??????_".date("YmdHis").".csv",
            ]);
            return ;
        }else{

            $model->loadDefaultValues();
            return $this->render('export', [
                'model' =>$model,
            ]);
        }
    }
    /**
     * Creates a new Supplier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Supplier();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Supplier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Supplier model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Supplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Supplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Supplier::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /**
     * ????????????
     * @param string $ids
     * @return  Csv
     */
    public function actionExpdata()
    {
        $field =\Yii::$app->request->post('field');
       // $filed=implode($fields,",");
         $sql="SELECT ".$field." FROM supplier";
        theCsv::export([
            'reader' => \Yii::$app->getDb()->createCommand($sql)->query(),
            'fields' => ['id', 'name','code','t_status'],
            'header' => ['Id', '??????', '??????','??????'],
        ]);
    }
}
