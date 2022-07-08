ALTER VIEW view_dep AS
select dep.id AS id,
       case when dep.interviewed = 'leader' then 'Líder'
            else 'Colaborador'
            end AS interviewed,
       dep.position_id AS position_id,
       position.description AS position,
       position_group.description AS position_group,
       directorate.description AS directorate,
       dep.mission AS mission,
       dep.experience_time AS experience_time,
       dep.leadership_time AS leadership_time,
       case when dep.allowhomeoffice = 0 then 'Aplicável totalmente'
            when dep.allowhomeoffice = 1 then 'Aplicável parcialmente'
            else 'Não Aplicável'
            end AS allowhomeoffice,
       dep.created_at AS created_at,
       dep.updated_at AS updated_at,
       dep.interviewer_comments AS interviewer_comments
  from position_description dep
       join position on position.id = dep.position_id
       left join position_group on position.position_group_id = position_group.id
       left join directorate on position.directorate_id = directorate.id;

ALTER VIEW view_dep_competence AS
select dep_competence.position_description_id AS dep_id,
       dep_competence.level AS competence_level,
       case when dep_competence.requirement = 'required' then 'Necessário (Obrigatório)'
            else 'Diferencial (Recomendado)' end AS competence_requirement,
       competence.id AS competence_id,
       competence.description AS competence_description,
       competence_level.id AS competence_level_id,
       competence_level.description AS competence_level_description,
       competence_level.competence_type_id AS competence_level_type_id,
       competence_type.id AS competence_type_id,
       competence_type.description AS competence_type_description
  from dep_competence
       join competence on dep_competence.competence_id = competence.id
       join competence_level on dep_competence.level = competence_level.id
       join competence_type on competence.competence_type_id = competence_type.id;

ALTER VIEW view_dep_grade AS
select dep_grade.position_description_id AS dep_id,
       case when dep_grade.requirement = 'required' then 'Necessário (Obrigatório)'
            else 'Diferencial (Recomendado)'
            end AS course_requirement,
       case when dep_grade.status = 'ongoing' then 'Em Andamento'
            else 'Completo'
            end AS course_status,
       grade_course.id AS course_id,
       grade_course.area_id AS course_area_id,
       grade_course.grade_id AS course_grade_id,
       grade_course.description AS course_description,
       grade.description AS grade_description,
       area.description AS area_description
  from dep_grade
       join grade_course on dep_grade.grade_id = grade_course.id
       join grade on grade_course.grade_id = grade.id
       join area on grade_course.area_id = area.id;

ALTER VIEW view_dep_language AS
select dep_language.position_description_id AS dep_id,
       case when dep_language.requirement = 'required' then 'Necessário (Obrigatório)'
            else 'Diferencial (Recomendado)'
            end AS language_requirement,
       case when dep_language.level = 'basic' then 'Básico'
            when dep_language.level = 'intermediate' then 'Intermediário'
            when dep_language.level = 'advanced' then 'Avançado'
            else 'Fluente'
            end AS language_level,
       case when dep_language.skill = 'talk' then 'Fala'
            when dep_language.skill = 'writing' then 'Escrita'
            when dep_language.skill = 'listening' then 'Escuta'
            else 'Leitura'
            end AS language_skill,
       language.id AS language_id,
       language.description AS language_description
  from dep_language
       join language on dep_language.language_id = language.id;

ALTER VIEW view_dep_maintarget_activity AS
select dep_maintarget.position_description_id AS dep_id,
       main_target.id AS main_target_id,
       main_target.description AS main_target_description,
       main_activity.id AS main_activity_id,
       main_activity.description AS main_activity_description,
       dep_maintarget.classification AS classification
  from dep_maintarget
       join main_target on dep_maintarget.maintarget_id = main_target.id
       join main_activity on dep_maintarget.mainactivity_id = main_activity.id;


ALTER VIEW view_position AS
select position.id,
       position.code,
       position.description AS position,
       position_group.description AS position_group,
       directorate.description AS directorate,
       position.salary_grade
  from position
       left join position_group on position.position_group_id = position_group.id
       left join directorate on position.directorate_id = directorate.id;
