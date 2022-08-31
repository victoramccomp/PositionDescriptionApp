UPDATE `position_description` 
    SET `restrictions` = 'Realizar tarefas correlatas de acordo com solicitação do gestor imediato.';


----------------------------------------------------------------------------------------------------------


CREATE TABLE `config_hide_target_classification` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `is_hidden` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `config_hide_target_classification` (`id`, `is_hidden`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-03-10 20:15:58', '2021-06-01 17:56:37');


CREATE TABLE `config_position_guidelines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `is_activated` tinyint(1) NOT NULL,
  `guidelines` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `config_position_guidelines` (`id`, `is_activated`, `guidelines`, `created_at`, `updated_at`) VALUES
(1, 1, 'Nenhuma Diretriz especificada', '2021-03-10 20:15:58', '2021-06-01 17:56:37');



CREATE TABLE `config_hide_target_activity` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `is_hidden` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `config_hide_target_activity` (`id`, `is_hidden`, `created_at`, `updated_at`) VALUES
(1, 0, '2021-03-10 20:15:58', '2021-06-01 17:56:37');


--------------------------------------------------------------------------------------------


ASSISTENTE	0	0
OPERADOR	0	2
-- ANALISTA JR	0	1
-- ANALISTA PL	0	2
-- ANALISTA SR	0	4
PLANEJADOR	0	3
-- TÉCNICO JR	0	1
-- TÉCNICO PL	0	2
-- TÉCNICO SR	0	3
AUXILIAR	0	0
ESPECIALISTA	0	6
COORDENADOR	0	6
DIRETOR	8	10
-- ENGENHEIRO JR	0	2
-- ENGENHEIRO PL	0	3
-- ENGENHEIRO SR	0	4
GERENTE	5	8
LÍDER	0	4
BOMBEIRO	0	3
PRESIDENTE	10	10
CONSULTOR	0	5
APRENDIZ	0	0


-- 1 ASSISTENTE
UPDATE `position_description` 
    SET `leadership_time` = 0,
        `experience_time` = 0
  JOIN `position` ON `position_description`.`position_id` = `position`.`id`
 WHERE `position`.`position_group_id` = 1;

-- 2 OPERADOR
UPDATE `position_description` 
    SET `leadership_time` = 0,
        `experience_time` = 2
  JOIN `position` ON `position_description`.`position_id` = `position`.`id`
 WHERE `position`.`position_group_id` = 2;

-- 3 ANALISTA JR
UPDATE `position_description` 
    SET `leadership_time` = 0,
        `experience_time` = 1
  JOIN `position` ON `position_description`.`position_id` = `position`.`id`
 WHERE `position`.`position_group_id` = 3
   AND `position`.`description` LIKE "% JR%";


-- 3 ANALISTA PL
UPDATE `position_description` 
    SET `leadership_time` = 0,
        `experience_time` = 2
  JOIN `position` ON `position_description`.`position_id` = `position`.`id`
 WHERE `position`.`position_group_id` = 3
   AND `position`.`description LIKE` "% PL%";


-- 3 ANALISTA SR
UPDATE `position_description` 
    SET `leadership_time` = 0,
        `experience_time` = 4
  JOIN `position` ON `position_description`.`position_id` = `position`.`id`
 WHERE `position`.`position_group_id` = 3
   AND `position`.`description LIKE` "% SR%";


-- 4 PLANEJADOR
UPDATE `position_description` 
    SET `leadership_time` = 0,
        `experience_time` = 3
  JOIN `position` ON `position_description`.`position_id` = `position`.`id`
 WHERE `position`.`position_group_id` = 4;

-- 5 TÉCNICO
UPDATE `position_description` 
    SET `leadership_time` = 0,
        `experience_time` = 1
  JOIN `position` ON `position_description`.`position_id` = `position`.`id`
 WHERE `position`.`position_group_id` = 5
   AND `position`.`description` LIKE "% JR%";
 

-- 5 TÉCNICO
UPDATE `position_description` 
    SET `leadership_time` = 0,
        `experience_time` = 2
  JOIN `position` ON `position_description`.`position_id` = `position`.`id`
 WHERE `position`.`position_group_id` = 5
   AND `position`.`description` LIKE "% PL%";


-- 5 TÉCNICO
UPDATE `position_description` 
    SET `leadership_time` = 0,
        `experience_time` = 3
  JOIN `position` ON `position_description`.`position_id` = `position`.`id`
 WHERE `position`.`position_group_id` = 5
   AND `position`.`description` LIKE "% SR%";

-- 6 AUXILIAR
UPDATE `position_description` 
    SET `leadership_time` = 0,
        `experience_time` = 0
  JOIN `position` ON `position_description`.`position_id` = `position`.`id`
 WHERE `position`.`position_group_id` = 6;

-- 7 ESPECIALISTA
UPDATE `position_description` 
    SET `leadership_time` = 0,
        `experience_time` = 6
  JOIN `position` ON `position_description`.`position_id` = `position`.`id`
 WHERE `position`.`position_group_id` = 7;

-- 8 COORDENADOR
UPDATE `position_description` 
    SET `leadership_time` = 0,
        `experience_time` = 6
  JOIN `position` ON `position_description`.`position_id` = `position`.`id`
 WHERE `position`.`position_group_id` = 8;

-- 9 DIRETOR
UPDATE `position_description` 
    SET `leadership_time` = 8,
        `experience_time` = 10
  JOIN `position` ON `position_description`.`position_id` = `position`.`id`
 WHERE `position`.`position_group_id` = 9;

-- 10 ENGENHEIRO
UPDATE `position_description` 
    SET `leadership_time` = ?,
        `experience_time` = ?
  JOIN `position` ON `position_description`.`position_id` = `position`.`id`
 WHERE `position`.`position_group_id` = 10;

-- 11 GERENTE
UPDATE `position_description` 
    SET `leadership_time` = 5,
        `experience_time` = 8
  JOIN `position` ON `position_description`.`position_id` = `position`.`id`
 WHERE `position`.`position_group_id` = 11;

-- 12 SUPERVISOR
UPDATE `position_description` 
    SET `leadership_time` = ?,
        `experience_time` = ?
  JOIN `position` ON `position_description`.`position_id` = `position`.`id`
 WHERE `position`.`position_group_id` = 12;

-- 13 LÍDER
UPDATE `position_description` 
    SET `leadership_time` = 0,
        `experience_time` = 4
  JOIN `position` ON `position_description`.`position_id` = `position`.`id`
 WHERE `position`.`position_group_id` = 13;

-- 14 BOMBEIRO
UPDATE `position_description` 
    SET `leadership_time` = 0,
        `experience_time` = 3
  JOIN `position` ON `position_description`.`position_id` = `position`.`id`
 WHERE `position`.`position_group_id` = 14;

-- 15 PRESIDENTE
UPDATE `position_description` 
    SET `leadership_time` = 10,
        `experience_time` = 10
  JOIN `position` ON `position_description`.`position_id` = `position`.`id`
 WHERE `position`.`position_group_id` = 15;

-- 16 CONSULTOR
UPDATE `position_description` 
    SET `leadership_time` = 0,
        `experience_time` = 5
  JOIN `position` ON `position_description`.`position_id` = `position`.`id`
 WHERE `position`.`position_group_id` = 16;

-- 17 APRENDIZ
UPDATE `position_description` 
    SET `leadership_time` = 0,
        `experience_time` = 0
  JOIN `position` ON `position_description`.`position_id` = `position`.`id`
 WHERE `position`.`position_group_id` = 17;