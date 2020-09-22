<?php

namespace yiiComponent\rbacAuthBehavior;

use Yii;
use yii\web\ForbiddenHttpException;
use yii\base\InvalidConfigException;

/**
 * RBAC权限认证行为
 *
 * Class RbacAuthBehavior
 * @package app\components\behaviors
 */
class RbacAuthBehavior extends \yii\base\ActionFilter
{
    /**
     * @var bool [$switchOn = true] 开关
     */
    public $switchOn = true;

    /**
     * @var string $userModel 用户模型
     */
    public $userModel;


    /**
     * @inheritdoc
     * @throws InvalidConfigException
     * @throws \ReflectionException
     */
    public function init()
    {
        parent::init();

        if ($this->userModel === null) {
            throw new InvalidConfigException(Yii::t('app/error', '{param} must be set.', ['param' => 'userModel']));
        }

        $model = new \ReflectionMethod($this->userModel,'getPermissions');
        if (!$model  || !$model->isStatic()) {
            throw new InvalidConfigException(Yii::t('app/error', '{param} must contain a static method with the name getPermissions.', ['param' => 'userModel']));
        }
    }

    /**
     * @inheritdoc
     * @throws \yii\web\ForbiddenHttpException
     */
    public function beforeAction($action)
    {
        $isPassed = parent::beforeAction($action);
        if (!$isPassed) {
            return $isPassed;
        }

        // 判断开关
        if (!$this->switchOn) {
            return true;
        }

        // 获取用户权限
        $userId       = $this->owner->user->id;
        $userModel    = $this->userModel;
        $permissions  = $userModel::getPermissions($userId);
        if (!$permissions) {
            throw new ForbiddenHttpException(Yii::t('app/error', 'You do not have permission to operate.'));
        }

        // 获取当前权限
        $moduleId     = $this->_getFullModuleId($action->controller->module, $ids = '');
        $moduleId     = $moduleId == 'base' ? '' : $moduleId;
        $controllerId = $action->controller->id;
        $actionId     = $action->id;
        $method       = Yii::$app->request->method;

        // 判断用户是否有权限
        foreach ($permissions as $permission) {
            if ($permission['modules'] === $moduleId &&
                $permission['controller'] === $controllerId &&
                $permission['action'] === $actionId &&
                $permission['method'] === $method) {

                return true;
            }
        }


        throw new ForbiddenHttpException(Yii::t('app/error', 'You do not have permission to operate.'));
    }


    /* ----private---- */

    /**
     * 获取路由完整模块ID
     *
     * @private
     * @param  object $module 模块对象
     * @param  string  $ids   模块ID
     * @return string
     */
    private function _getFullModuleId($module, &$ids)
    {
        if (isset($module->id)) {
            $ids = $ids ? $module->id . '/' . $ids : $module->id;

            if ($module->module) {
                // 过滤框架ID
                if ($module->module->id != Yii::$app->id) {
                    $this->_getFullModuleId($module->module, $ids);
                }
            }
        }

        return $ids;
    }
}
