<?php

use yiiComponent\rbacAuthBehavior\RbacAuthBehavior;

/**
 * Class CommonController
 * RbacAuthBehavior 调用实例
 */
class CommonController extends \yii\rest\ActiveController
{
    /**
     * 行为
     *
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['user'] = Yii::$app->admin;
        $behaviors['rbac'] = [
            'class' => RbacAuthBehavior::className(),
            'switchOn' => Yii::$app->params['rbacSwitch']['admin'],
            'userModel' => 'yiiComponent\rbacAuthBehavior\models\Admin',
        ];

        return $behaviors;
    }
}
