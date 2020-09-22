
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for xi_admin_permission
-- ----------------------------
DROP TABLE IF EXISTS `xi_admin_permission`;
CREATE TABLE `xi_admin_permission`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '菜单ID',
  `title` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `route` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '路由（完整路径）',
  `method` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '请求方式',
  `modules` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '模块',
  `controller` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '控制器',
  `action` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '方法',
  `is_trash` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否删除，0=>否，1=>是',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态，0=>禁用，1=>启用',
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  `deleted_at` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `title`(`menu_id`, `title`, `is_trash`, `deleted_at`),
  CONSTRAINT `xi_admin_permission_fk_menu_id` FOREIGN KEY (`menu_id`) REFERENCES `xi_admin_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '管理员权限' ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
