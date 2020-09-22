<?php

namespace yiiComponent\rbacAuthBehavior;

use Yii;
use yiiComponent\rbacAuthBehavior\models\AdminMenu;
use yiiComponent\rbacAuthBehavior\models\AdminPermission;

/**
 * Class AutomaticCreatePermissions
 *
 * @package app\forms\permission
 */
class AutomaticCreatePermissions  extends \yii\base\Model
{
    /**
     * @var array $data 数据
     */
    public $data;


    /**
     * 提交
     *
     * @return int|void
     * @throws \yii\db\Exception
     */
    public function submit()
    {
        $newPermissionsData = [];
        foreach ($this->data as $v) {
            $controller = substr(strrchr($v['controller'], '/'), 1) ;
            $modules = substr($v['controller'], 0, strrpos($v['controller'], '/')) ;

            // restfull的action
            $restFullActions = ['index', 'view', 'create', 'update', 'delete'];
            if ($v['except']) {
                $restFullActions = array_diff($restFullActions, $v['except']);
            }

            $actions = [];
            foreach ($restFullActions as $value) {
                switch ($value) {
                    case 'index':
                        $route = $modules . '/' . $controller;
                        $method = 'GET';
                        $restFullTitle = '列表';
                        break;
                    case 'view':
                        $route = $modules . '/' . $controller . '/:id';
                        $method = 'GET';
                        $restFullTitle = '详情';
                        break;
                    case 'create':
                        $route = $modules . '/' . $controller;
                        $method = 'POST';
                        $restFullTitle = '创建';
                        break;
                    case 'update':
                        $route = $modules . '/' . $controller . '/:id';
                        $method = 'PUT';
                        $restFullTitle = '更新';
                        break;
                    case 'delete':
                        $route = $modules . '/' . $controller . '/:id';
                        $method = 'DELETE';
                        $restFullTitle = '删除';
                        break;
                }

                $actions[] = [
                    'title' => $v['title'] . '-' . $restFullTitle,
                    'action' => $value,
                    'route' => $route,
                    'method' => $method,
                ];
            }

            // 处理自定义的action
            if ($v['extraPatterns']) {
                foreach ($v['extraPatterns'] as $key => $item) {
                    $keyArr = explode(' ', $key);
                    $itemArr = explode(' ', $item);
                    $route = $modules . '/' . $controller . '/' . str_replace('<id>', ':id', $keyArr[1]);
                    $actions[] = [
                        'title' => $v['title'] . '-' . $itemArr[1],
                        'action' => $itemArr[0],
                        'route' => $route,
                        'method' => $keyArr[0],
                    ];
                }
            }

            // 所有方法
            foreach ($actions as $action) {
                $newPermissionsData[] = [
                    'menu_id' => $this->_getMenuId($v['title']),
                    'title' => $action['title'],
                    'modules' => $modules,
                    'controller' => $controller,
                    'action' => $action['action'],
                    'route' => $action['route'],
                    'method' => $action['method'],
                ];
            }
        }

        $newPermissionsData = $this->_filterData($newPermissionsData);

        return $this->_batchInsert($newPermissionsData);
    }


    /* ----private---- */

    /**
     * 过滤数据
     *
     * @param $newPermissionsData
     * @return mixed
     */
    private function _filterData($newPermissionsData)
    {
        // 过滤数据
        $model = new AdminPermission;
        $allPermissions = $model->find()->where(['is_trash' => 0])->asArray()->all();
        foreach ($newPermissionsData as $key => $action) {
            foreach ($allPermissions as $v) {
                if ($action['menu_id'] == $v['menu_id'] && $action['modules'] == $v['modules'] && $action['controller'] == $v['controller'] && $action['action'] == $v['action'] && $action['method'] == $v['method']) {
                    unset($newPermissionsData[$key]);
                }
            }
        }

        return $newPermissionsData;
    }

    /**
     * 批量插入
     *
     * @param $newPermissionsData
     * @return int|void
     * @throws \yii\db\Exception
     */
    private function _batchInsert($newPermissionsData)
    {
        // 批量入库
        $insertData = [];
        foreach ($newPermissionsData as $v) {
            $insertData[] = [
                'menu_id' => $v['menu_id'],
                'title' => $v['title'],
                'route' => $v['route'],
                'method' => $v['method'],
                'modules' => $v['modules'],
                'controller' => $v['controller'],
                'action' => $v['action'],
            ];
        }

        if ($insertData) {
            $rows = Yii::$app->db->createCommand()
                ->batchInsert(
                    AdminPermission::tableName(),
                    [
                        'menu_id',
                        'title',
                        'route',
                        'method',
                        'modules',
                        'controller',
                        'action',
                    ],
                    $insertData
                )->execute();

            return $rows;
        }
    }

    /**
     * 获取菜单ID
     *
     * @param $title
     * @return int
     */
    private function _getMenuId($title)
    {
        $titleArr = explode('-', $title);
        $parentId = null;
        foreach ($titleArr as $value) {
            $modelParent = AdminMenu::find()
                ->andWhere(['is_trash' => 0, 'name' => trim($value)])
                ->andFilterWhere(['parent_id' => $parentId])
                ->asArray()
                ->one();
            if ($modelParent) {
                $parentId = $modelParent['id'];
                continue;
            } else {
                break;
            }
        }

        return $parentId;
    }
}
