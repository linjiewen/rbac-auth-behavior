
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for xi_admin_assign_role
-- ----------------------------
DROP TABLE IF EXISTS `xi_admin_assign_role`;
CREATE TABLE `xi_admin_assign_role`  (
  `admin_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '管理员ID',
  `role_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '角色ID',
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`admin_id`, `role_id`),
  INDEX `xi_admin_assign_role_fk_role_id`(`role_id`),
  CONSTRAINT `xi_admin_assign_role_fk_admin_id` FOREIGN KEY (`admin_id`) REFERENCES `xi_admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `xi_admin_assign_role_fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `xi_admin_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '管理员角色分配' ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
