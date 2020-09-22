<?php

namespace yiiComponent\rbacAuthBehavior\models;

use Yii;

/**
 * This is the model class for table "{{%admin_role}}".
 *
 * @property int $id
 * @property string $name 名称
 * @property string $permissions 权限（json）
 * @property string $description 描述
 * @property int $is_trash 是否删除，0=>否，1=>是
 * @property int $status 状态，0=>禁用，1=>启用
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 * @property string $deleted_at 删除时间
 *
 * @property AdminAssignRole[] $adminAssignRoles
 * @property Admin[] $admins
 */
class AdminRole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin_role}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_trash', 'status'], 'integer', 'min' => 0],
            [['permissions'], 'required'],
            [['permissions'], 'string'],
            [['name'], 'string', 'max' => 64],
            [['description'], 'string', 'max' => 255],
            [['deleted_at'], 'string', 'max' => 32],

            [['created_at', 'updated_at'], 'datetime', 'format' => 'yyyy-MM-dd HH:mm:ss'],

            [['name', 'permissions', 'description', 'deleted_at'], 'default', 'value' => ''],
            [['is_trash'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],

            [['name', 'is_trash', 'deleted_at'], 'unique', 'targetAttribute' => ['name', 'is_trash', 'deleted_at'], 'message' => 'The name already exists.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '名称'),
            'permissions' => Yii::t('app', '权限（json）'),
            'description' => Yii::t('app', '描述'),
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
    public function getAdminAssignRoles()
    {
        return $this->hasMany(AdminAssignRole::className(), ['role_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmins()
    {
        return $this->hasMany(Admin::className(), ['id' => 'admin_id'])->viaTable('{{%admin_assign_role}}', ['role_id' => 'id']);
    }
}
