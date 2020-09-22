
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for xi_admin
-- ----------------------------
DROP TABLE IF EXISTS `xi_admin`;
CREATE TABLE `xi_admin`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '加密密码',
  `password_reset_token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '重置密码令牌',
  `auth_key` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '认证密钥',
  `access_token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '访问令牌',
  `mobile` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '手机号码',
  `realname` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '真实姓名',
  `is_trash` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否删除，0=>否，1=>是',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态，0=>禁用，1=>启用',
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  `deleted_at` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '删除时间',
  `last_login_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后登录时间',
  `last_login_ip` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `allowance` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '请求剩余次数',
  `allowance_updated_at` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '请求更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`, `is_trash`, `deleted_at`) USING BTREE,
  UNIQUE INDEX `access_token`(`access_token`, `is_trash`, `deleted_at`) USING BTREE,
  UNIQUE INDEX `auth_key`(`auth_key`, `is_trash`, `deleted_at`) USING BTREE,
  UNIQUE INDEX `password_reset_token`(`password_reset_token`, `is_trash`, `deleted_at`) USING BTREE,
  UNIQUE INDEX `mobile`(`mobile`, `is_trash`, `deleted_at`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '管理员' ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
