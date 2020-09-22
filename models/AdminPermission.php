<?php

namespace yiiComponent\rbacAuthBehavior\models;

use Yii;

/**
 * This is the model class for table "{{%admin_permission}}".
 *
 * @property int $id
 * @property int $menu_id 菜单ID
 * @property string $title 标题
 * @property string $route 路由（完整路径）
 * @property string $method 请求方式
 * @property string $modules 模块
 * @property string $controller 控制器
 * @property string $action 方法
 * @property int $is_trash 是否删除，0=>否，1=>是
 * @property int $status 状态，0=>禁用，1=>启用
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 * @property string $deleted_at 删除时间
 *
 * @property AdminMenu $menu
 */
class AdminPermission extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin_permission}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'menu_id', 'is_trash', 'status'], 'integer', 'min' => 0],
            [['title', 'route'], 'string', 'max' => 128],
            [['method'], 'string', 'max' => 16],
            [['modules'], 'string', 'max' => 64],
            [['controller', 'action', 'deleted_at'], 'string', 'max' => 32],

            [['created_at', 'updated_at'], 'datetime', 'format' => 'yyyy-MM-dd HH:mm:ss'],

            [['menu_id', 'is_trash'], 'default', 'value' => 0],
            [['title', 'route', 'method', 'modules', 'controller', 'action', 'deleted_at'], 'default', 'value' => ''],
            [['status'], 'default', 'value' => 1],

            [['menu_id', 'title', 'is_trash', 'deleted_at'], 'unique', 'targetAttribute' => ['menu_id', 'title', 'is_trash', 'deleted_at'], 'message' => 'The menu_id and title combination already exists.'],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdminMenu::className(), 'targetAttribute' => ['menu_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'menu_id' => Yii::t('app', '菜单ID'),
            'title' => Yii::t('app', '标题'),
            'route' => Yii::t('app', '路由（完整路径）'),
            'method' => Yii::t('app', '请求方式'),
            'modules' => Yii::t('app', '模块'),
            'controller' => Yii::t('app', '控制器'),
            'action' => Yii::t('app', '方法'),
            'is_trash' => Yii::t('app', '是否删除，0=>否，1=>是'),
            'status' => Yii::t('app', '状态，0=>禁用，1=>启用'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
            'deleted_at' => Yii::t('app', '删除时间'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(AdminMenu::className(), ['id' => 'menu_id']);
    }
}
