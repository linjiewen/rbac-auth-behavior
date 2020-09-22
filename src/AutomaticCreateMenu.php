<?php

namespace yiiComponent\rbacAuthBehavior;

use yiiComponent\rbacAuthBehavior\models\AdminMenu;

/**
 * Class AutomaticCreateMenu
 *
 * @package app\forms\permission
 */
class AutomaticCreateMenu  extends \yii\base\Model
{
    /**
     * @var array $data 数据
     */
    public $data;


    /**
     * 提交
     *
     * @return void
     */
    public function submit()
    {
        $model = new AdminMenu();
        // 父栏目
        $firstMenu = $model->find()
            ->where(['is_trash' => 0, 'parent_id' => null])
            ->asArray()
            ->all();

        // 子栏目
        $childMenu = $model->find()
            ->where(['is_trash' => 0])
            ->andWhere(['not', ['parent_id' => null]])
            ->asArray()
            ->all();

        $childNames = $this->groupByArrayByKey($childMenu, 'parent_id', 'name');

        foreach ($this->data as $key => $value) {
            $parentId = 0;
            foreach ($firstMenu as $item) {
                if ($key == $item['name']) {
                    $parentId = $item['id'];
                }
            }

            if (!$parentId) {
                $MenuModel = new AdminMenu;
                $MenuModel->parent_id = null;
                $MenuModel->name = $key;
                if (!$MenuModel->save()) {
                    echo '一级栏目：' . $key . '添加失败' . PHP_EOL;
                    continue;
                }

                $parentId = $MenuModel->id;
            }

            if (!$parentId) {
                continue;
            }

            foreach ($value as $v) {
                if ($childNames[$parentId] && in_array($v, $childNames[$parentId])) {
                    continue;
                }

                $MenuModel = new AdminMenu;
                $MenuModel->parent_id = $parentId;
                $MenuModel->name = $v;
                if (!$MenuModel->save()) {
                    echo $key . $v . '添加失败' . PHP_EOL;
                }
            }
        }
    }

    /**
     * 处理数组
     *
     * @param $array
     * @param $key
     * @param $valueKey
     * @return array
     */
    private function groupByArrayByKey($array, $key, $valueKey)
    {
        $data = [];
        foreach ($array as $value) {
            $data[$value[$key]][] = $value[$valueKey];
        }

        return $data;
    }
}
