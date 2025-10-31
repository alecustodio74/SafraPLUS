-- Remove verificações de chaves estrangeiras para evitar erros de ordem
SET FOREIGN_KEY_CHECKS=0;

-- 1. Tabela de Produtores (Usuários)
DROP TABLE IF EXISTS `produtores`;
CREATE TABLE `produtores` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `cpf_cnpj` varchar(20) NOT NULL,
  `propriedade` varchar(255) DEFAULT NULL,
  `cultura_principal` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'produtor',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `produtores_cpf_cnpj_unique` (`cpf_cnpj`),
  UNIQUE KEY `produtores_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Tabela de Safras
DROP TABLE IF EXISTS `safras`;
CREATE TABLE `safras` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `produtor_id` bigint(20) unsigned NOT NULL,
  `cultura` varchar(100) NOT NULL,
  `area_plantada` decimal(10,2) DEFAULT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date DEFAULT NULL,
  `localizacao` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `safras_produtor_id_foreign` (`produtor_id`),
  CONSTRAINT `safras_produtor_id_foreign` FOREIGN KEY (`produtor_id`) REFERENCES `produtores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Tabela de Categorias
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `produtor_id` bigint(20) unsigned NOT NULL,
  `nome` varchar(255) NOT NULL,
  `tipo_receita_despesa` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categorias_produtor_id_foreign` (`produtor_id`),
  CONSTRAINT `categorias_produtor_id_foreign` FOREIGN KEY (`produtor_id`) REFERENCES `produtores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Tabela de Insumos
DROP TABLE IF EXISTS `insumos`;
CREATE TABLE `insumos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `produtor_id` bigint(20) unsigned NOT NULL,
  `nome` varchar(255) NOT NULL,
  `estoque_atual` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `insumos_produtor_id_foreign` (`produtor_id`),
  CONSTRAINT `insumos_produtor_id_foreign` FOREIGN KEY (`produtor_id`) REFERENCES `produtores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Tabela de Maquinários
DROP TABLE IF EXISTS `maquinarios`;
CREATE TABLE `maquinarios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `produtor_id` bigint(20) unsigned NOT NULL,
  `nome` varchar(255) NOT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `ano` year(4) DEFAULT NULL,
  `descricao_atividade` text DEFAULT NULL,
  `custo_hora` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `maquinarios_produtor_id_foreign` (`produtor_id`),
  CONSTRAINT `maquinarios_produtor_id_foreign` FOREIGN KEY (`produtor_id`) REFERENCES `produtores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Tabela de Mão de Obra
DROP TABLE IF EXISTS `mao_de_obra`;
CREATE TABLE `mao_de_obra` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `produtor_id` bigint(20) unsigned NOT NULL,
  `nome_ou_tipo` varchar(255) NOT NULL,
  `custo_diario_hora` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mao_de_obra_produtor_id_foreign` (`produtor_id`),
  CONSTRAINT `mao_de_obra_produtor_id_foreign` FOREIGN KEY (`produtor_id`) REFERENCES `produtores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Tabela de Lançamentos Financeiros
DROP TABLE IF EXISTS `lancamentos_financeiros`;
CREATE TABLE `lancamentos_financeiros` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `safra_id` bigint(20) unsigned NOT NULL,
  `categoria_id` bigint(20) unsigned NOT NULL,
  `data` date DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `tipo_receita_custo` varchar(255) NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `valor_liquido` decimal(10,2) DEFAULT NULL,
  `data_lancamento` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lancamentos_financeiros_safra_id_foreign` (`safra_id`),
  KEY `lancamentos_financeiros_categoria_id_foreign` (`categoria_id`),
  CONSTRAINT `lancamentos_financeiros_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lancamentos_financeiros_safra_id_foreign` FOREIGN KEY (`safra_id`) REFERENCES `safras` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Tabela de Custos Operacionais
DROP TABLE IF EXISTS `custos_operacionais`;
CREATE TABLE `custos_operacionais` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `safra_id` bigint(20) unsigned NOT NULL,
  `maquinario_id` bigint(20) unsigned DEFAULT NULL,
  `mao_de_obra_id` bigint(20) unsigned DEFAULT NULL,
  `data` date NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `custos_operacionais_safra_id_foreign` (`safra_id`),
  KEY `custos_operacionais_maquinario_id_foreign` (`maquinario_id`),
  KEY `custos_operacionais_mao_de_obra_id_foreign` (`mao_de_obra_id`),
  CONSTRAINT `custos_operacionais_mao_de_obra_id_foreign` FOREIGN KEY (`mao_de_obra_id`) REFERENCES `mao_de_obra` (`id`) ON DELETE SET NULL,
  CONSTRAINT `custos_operacionais_maquinario_id_foreign` FOREIGN KEY (`maquinario_id`) REFERENCES `maquinarios` (`id`) ON DELETE SET NULL,
  CONSTRAINT `custos_operacionais_safra_id_foreign` FOREIGN KEY (`safra_id`) REFERENCES `safras` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Tabela de Movimentações de Estoque
DROP TABLE IF EXISTS `movimentacoes_estoque`;
CREATE TABLE `movimentacoes_estoque` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_movimentacao` varchar(255) NOT NULL,
  `insumo_id` bigint(20) unsigned NOT NULL,
  `safra_id` bigint(20) unsigned DEFAULT NULL,
  `quantidade` decimal(10,2) NOT NULL DEFAULT 0.00,
  `valor_unitario` decimal(10,2) DEFAULT NULL,
  `data_movimentacao` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `movimentacoes_estoque_insumo_id_foreign` (`insumo_id`),
  KEY `movimentacoes_estoque_safra_id_foreign` (`safra_id`),
  CONSTRAINT `movimentacoes_estoque_insumo_id_foreign` FOREIGN KEY (`insumo_id`) REFERENCES `insumos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `movimentacoes_estoque_safra_id_foreign` FOREIGN KEY (`safra_id`) REFERENCES `safras` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Tabelas Padrão do Laravel
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Ativa as verificações de chaves estrangeiras novamente
SET FOREIGN_KEY_CHECKS=1;