
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for xi_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `xi_admin_menu`;
CREATE TABLE `xi_admin_menu`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '父ID',
  `name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '名称',
  `is_trash` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否删除，0=>否，1=>是',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态，0=>禁用，1=>启用',
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  `deleted_at` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`parent_id`, `name`, `is_trash`, `deleted_at`) USING BTREE,
  CONSTRAINT `xi_admin_menu_fk_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `xi_admin_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '管理员后台菜单' ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
