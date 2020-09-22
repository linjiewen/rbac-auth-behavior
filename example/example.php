<?php

use \yiiComponent\rbacAuthBehavior\AutomaticCreateMenu;
use \yiiComponent\rbacAuthBehavior\AutomaticCreatePermissions;

/**
 * 自动创建菜单 - 调用实例
 *
 * @return void
 */
function actionMenu()
{
    $model = new AutomaticCreateMenu();
    // 整理后台的菜单栏目数据
    $model->data = [
        '首页' => [
            '仪表盘'
        ],
        '系统管理' => [
            '账户管理',
            '角色管理',
            '权限管理',
            '菜单管理',
            '权限管理',
            '日志管理',
        ],
        '商家管理' => [
            '商家列表',
            '账户管理',
            '分组管理',
            '等级管理',
            '日志管理',
        ],
        '商品管理' => [
            '商品列表',
            '类型管理',
        ],
        '数据中心' => [
            '商品流向',
            '商品库存',
            '销售价格',
        ],
    ];

    $model->submit();
}

/**
 * 自动创建权限 - 调用实例
 *
 * @return void
 * @throws \yii\db\Exception
 */
function actionPermission()
{
    $model = new AutomaticCreatePermissions();
    // 整理项目的路由数据
    $model->data = [
        // 管理员端-首页-仪表盘
        [
            'title' => '首页-仪表盘',
            'class'         => 'yii\rest\UrlRule',
            'controller'    => 'v1/admin/index/dashboard',
            'except'        => ['index', 'view', 'create', 'update', 'delete'],
            'pluralize'     => false,
            'extraPatterns' => [
                'GET total' => 'total 统计',
            ],
        ],

        // 管理员端 - 系统管理 - 账户管理
        [
            'title' => '系统管理-账户管理',
            'class'         => 'yii\rest\UrlRule',
            'controller'    => 'v1/admin/admin/index',
            'extraPatterns' => [
                'PATCH status/<id>'         => 'status 状态',
                'PATCH reset-password/<id>' => 'reset-password 重置密码',
                'POST assign-role/<id>'     => 'assign-role 分配角色',
            ],
        ],

        // 管理员端 - 系统管理 - 角色管理
        [
            'title' => '系统管理-角色管理',
            'class'         => 'yii\rest\UrlRule',
            'controller'    => 'v1/admin/admin/role',
            'extraPatterns' => [
                'PATCH status/<id>' => 'status 状态',
            ],
        ],

        // 管理员端 - 系统管理 - 权限管理
        [
            'title' => '系统管理-权限管理',
            'class'         => 'yii\rest\UrlRule',
            'controller'    => 'v1/admin/admin/permission',
            'extraPatterns' => [
                'PATCH status/<id>' => 'status 状态',
            ],
        ],

        // 管理员端 - 系统管理 - 菜单管理
        [
            'title' => '系统管理-菜单管理',
            'class'         => 'yii\rest\UrlRule',
            'controller'    => 'v1/admin/admin/menu',
            'extraPatterns' => [
                'PATCH status/<id>' => 'status 状态',
                'GET tree' => 'tree 树',
            ],
        ],

        // 管理员端 - 系统管理 - 日志管理
        [
            'title' => '系统管理-日志管理',
            'class'         => 'yii\rest\UrlRule',
            'controller'    => 'v1/admin/admin/log',
            'except'        => ['create', 'update', 'delete'],
        ],

        // 管理员端 - 商家管理 - 商家列表
        [
            'title' => '商家管理-商家列表',
            'class'         => 'yii\rest\UrlRule',
            'controller'    => 'v1/admin/merchant/index',
            'extraPatterns' => [
                'PATCH status/<id>' => 'status 状态',
                'GET salesman' => 'salesman 销售代表',
            ],
        ],

        // 管理员端 - 商家管理 - 等级管理
        [
            'title' => '商家管理-等级管理',
            'class'         => 'yii\rest\UrlRule',
            'controller'    => 'v1/admin/merchant/level',
            'extraPatterns' => [
                'PATCH status/<id>' => 'status 状态',
            ],
        ],

        // 管理员端 - 商家管理 - 账号管理
        [
            'title' => '商家管理-账号管理',
            'class'         => 'yii\rest\UrlRule',
            'controller'    => 'v1/admin/merchant/account',
            'extraPatterns' => [
                'PATCH status/<id>' => 'status 状态',
            ],
        ],

        // 管理员端 - 商家管理 - 字段管理
        [
            'title' => '商家管理-字段管理',
            'class'         => 'yii\rest\UrlRule',
            'controller'    => 'v1/admin/merchant/field',
            'except'        => ['view', 'create', 'update', 'delete'],
            'extraPatterns' => [
                'GET export' => 'export 导出',
            ],
        ],

        // 管理员端 - 商家管理 - 流向管理
        [
            'title' => '商家管理-流向管理',
            'class'         => 'yii\rest\UrlRule',
            'controller'    => 'v1/admin/merchant/flow-direction',
            'except'        => ['index', 'view', 'create', 'update', 'delete'],
            'extraPatterns' => [
                'POST import' => 'import 导入',
                'PUT field'   => 'field-update 字段匹配-更新',
                'GET field'   => 'field-view 字段匹配-详情',
            ],
        ],

        // 管理员端 - 商品管理 - 商品列表
        [
            'title' => '商品管理-商品列表',
            'class'         => 'yii\rest\UrlRule',
            'controller'    => 'v1/admin/goods/index',
            'extraPatterns' => [
                'PATCH status/<id>' => 'status 状态',
                'GET export' => 'export 导出',
            ],
        ],

        // 管理员端 - 商品管理 - 商品类型
        [
            'title' => '商品管理-类型管理',
            'class'         => 'yii\rest\UrlRule',
            'controller'    => 'v1/admin/goods/type',
            'extraPatterns' => [
                'PATCH status/<id>' => 'status 状态',
            ],
        ],

        // 管理员端 - 数据中心 - 商品流向
        [
            'title' => '数据中心-商品流向',
            'class'         => 'yii\rest\UrlRule',
            'controller'    => 'v1/admin/data/goods-flow-direction',
            'except'        => ['view', 'create', 'update'],
            'extraPatterns' => [
                'GET action-log' => 'action-log 操作日志',
                'GET export' => 'export 导出',
            ],
        ],

        // 管理员端 - 数据中心 - 商品库存
        [
            'title' => '数据中心-商品库存',
            'class'         => 'yii\rest\UrlRule',
            'controller'    => 'v1/admin/data/goods-inventory',
            'except'        => ['view', 'create', 'update'],
            'extraPatterns' => [
                'GET action-log' => 'action-log 操作日志',
                'GET export' => 'export 导出',
            ],
        ],
    ];

    return $model->submit();
}
