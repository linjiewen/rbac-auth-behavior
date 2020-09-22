<?php

namespace yiiComponent\rbacAuthBehavior\models;

use Yii;

/**
 * This is the model class for table "{{%admin_menu}}".
 *
 * @property int $id
 * @property int $parent_id 父ID
 * @property string $name 名称
 * @property int $is_trash 是否删除，0=>否，1=>是
 * @property int $status 状态，0=>禁用，1=>启用
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 * @property string $deleted_at 删除时间
 *
 * @property AdminMenu $parent
 * @property AdminMenu[] $adminMenus
 * @property AdminPermission[] $adminPermissions
 */
class AdminMenu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin_menu}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'is_trash', 'status'], 'integer', 'min' => 0],
            [['name', 'deleted_at'], 'string', 'max' => 32],

            [['created_at', 'updated_at'], 'datetime', 'format' => 'yyyy-MM-dd HH:mm:ss'],

            [['parent_id'], 'default', 'value' => null],
            [['name', 'deleted_at'], 'default', 'value' => ''],
            [['is_trash'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],

            [['parent_id', 'name', 'is_trash', 'deleted_at'], 'unique', 'targetAttribute' => ['parent_id', 'name', 'is_trash', 'deleted_at'], 'message' => 'The parent_id and name combination already exists.'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdminMenu::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', '父ID'),
            'name' => Yii::t('app', '名称'),
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
    public function getParent()
    {
        return $this->hasOne(AdminMenu::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminMenus()
    {
        return $this->hasMany(AdminMenu::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminPermissions()
    {
        return $this->hasMany(AdminPermission::className(), ['menu_id' => 'id']);
    }
}
