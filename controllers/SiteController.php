<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use app\models\MSchoolList;
use app\models\MZonalEduList;
use app\models\MProvincialList;
use yii\helpers\Json;

ob_start();

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }*/

    
    public $freeAccessActions  = ['business_list'];

    public function behaviors()
    {
        return [
            'ghost-access'=> [
                'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionReports()
    {
        return $this->render('reports');
    }

    public function actionAdmin_panel()
    {
        return $this->render('admin_panel');
    }

    public function actionLoad_user_level_values() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            if($id=='school'){         
                $list = MSchoolList::find()->andWhere(['status'=>1])->asArray()->all();
                $selected  = null;
                if ($id != null && count($list) > 0) {
                    $selected = '';
                    foreach ($list as $i => $account) {
                        $out[] = ['id' => $account['id'], 'name' => $account['school_name']];
                        if ($i == 0) {
                            $selected = $account['id'];
                        }
                    }
                    // Shows how you can preselect a value
                    echo Json::encode(['output' => $out, 'selected'=>$selected]);
                    return;
                }
            }
            else if($id=='zone'){            
                $list = MZonalEduList::find()->andWhere(['status'=>1])->asArray()->all();
                $selected  = null;
                if ($id != null && count($list) > 0) {
                    $selected = '';
                    foreach ($list as $i => $account) {
                        $out[] = ['id' => $account['zonal_id'], 'name' => $account['zonal_name']];
                        if ($i == 0) {
                            $selected = $account['zonal_id'];
                        }
                    }
                    // Shows how you can preselect a value
                    echo Json::encode(['output' => $out, 'selected'=>$selected]);
                    return;
                }
            }
            else if($id=='province'){            
                $list = MProvincialList::find()->andWhere(['status'=>1])->asArray()->all();
                $selected  = null;
                if ($id != null && count($list) > 0) {
                    $selected = '';
                    foreach ($list as $i => $account) {
                        $out[] = ['id' => $account['id'], 'name' => $account['provincial_name']];
                        if ($i == 0) {
                            $selected = $account['id'];
                        }
                    }
                    // Shows how you can preselect a value
                    echo Json::encode(['output' => $out, 'selected'=>$selected]);
                    return;
                }
            }


        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }


    function actionAdmin_main(){
        return $this->render('admin_main');
    }


    public function actionBusiness_list($q=null) {
        $query = new \yii\db\Query;
        //$q = $_GET['q'];
        $query->select('business_name')
            ->from('acc_business')
            ->where('business_name LIKE "%' . $q .'%"')
            ->orderBy('business_name');
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['business_name']];
        }
        echo Json::encode($out);
    }

    function actionUser_permission(){
        return $this->render('user_permission');
    }

}
