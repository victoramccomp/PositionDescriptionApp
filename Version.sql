CREATE TABLE `config_hide_target_classification` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `is_hidden` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `config_hide_target_classification`
--

INSERT INTO `config_hide_target_classification` (`id`, `is_hidden`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-03-10 20:15:58', '2021-06-01 17:56:37');


CREATE TABLE `config_position_guidelines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `is_activated` tinyint(1) NOT NULL,
  `guidelines` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `config_position_guidelines`
--

INSERT INTO `config_position_guidelines` (`id`, `is_activated`, `guidelines`, `created_at`, `updated_at`) VALUES
(1, 1, 'Preencha seus termos de uso e política de privacidade', '2021-03-10 20:15:58', '2021-06-01 17:56:37');
