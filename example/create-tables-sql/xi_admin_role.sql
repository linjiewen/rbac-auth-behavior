
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for xi_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `xi_admin_role`;
CREATE TABLE `xi_admin_role`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '名称',
  `permissions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '权限（json）',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '描述',
  `is_trash` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否删除，0=>否，1=>是',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态，0=>禁用，1=>启用',
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  `deleted_at` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name`(`name`, `is_trash`, `deleted_at`)
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '管理员角色' ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
