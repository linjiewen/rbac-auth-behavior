<?php

namespace yiiComponent\rbacAuthBehavior\models;

use Yii;

/**
 * This is the model class for table "{{%admin_assign_role}}".
 *
 * @property int $admin_id 管理员ID
 * @property int $role_id 角色ID
 * @property string $created_at 创建时间
 *
 * @property Admin $admin
 * @property AdminRole $role
 */
class AdminAssignRole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin_assign_role}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['admin_id', 'role_id'], 'required'],

            [['id', 'admin_id', 'role_id'], 'integer', 'min' => 0],

            [['created_at'], 'datetime', 'format' => 'yyyy-MM-dd HH:mm:ss'],

            [['admin_id', 'role_id'], 'default', 'value' => ''],

            [['admin_id', 'role_id'], 'unique', 'targetAttribute' => ['admin_id', 'role_id'], 'message' => 'The admin_id and role_id combination already exists.'],
            [['admin_id'], 'exist', 'skipOnError' => true, 'targetClass' => Admin::className(), 'targetAttribute' => ['admin_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdminRole::className(), 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'admin_id' => Yii::t('app', '管理员ID'),
            'role_id' => Yii::t('app', '角色ID'),
            'created_at' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne(Admin::className(), ['id' => 'admin_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(AdminRole::className(), ['id' => 'role_id']);
    }
}
