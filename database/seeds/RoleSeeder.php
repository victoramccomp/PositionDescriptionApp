<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Role::create( [ 'role' => 'create', 'screen' => 'area', 'screen_name' => 'Área', 'role_name' => 'Adicionar' ] );
        Role::create( [ 'role' => 'update', 'screen' => 'area', 'screen_name' => 'Área', 'role_name' => 'Editar' ] );
        Role::create( [ 'role' => 'delete', 'screen' => 'area', 'screen_name' => 'Área', 'role_name' => 'Excluir' ] );
        Role::create( [ 'role' => 'read', 'screen' => 'area', 'screen_name' => 'Área', 'role_name' => 'Leitura' ] );
        Role::create( [ 'role' => 'create', 'screen' => 'competence', 'screen_name' => 'Competências', 'role_name' => 'Adicionar' ] );
        Role::create( [ 'role' => 'update', 'screen' => 'competence', 'screen_name' => 'Competências', 'role_name' => 'Editar' ] );
        Role::create( [ 'role' => 'delete', 'screen' => 'competence', 'screen_name' => 'Competências', 'role_name' => 'Excluir' ] );
        Role::create( [ 'role' => 'read', 'screen' => 'competence', 'screen_name' => 'Competências', 'role_name' => 'Leitura' ] );
        Role::create( [ 'role' => 'create', 'screen' => 'competence_level', 'screen_name' => 'Nível da Competência', 'role_name' => 'Adicionar' ] );
        Role::create( [ 'role' => 'update', 'screen' => 'competence_level', 'screen_name' => 'Nível da Competência', 'role_name' => 'Editar' ] );
        Role::create( [ 'role' => 'delete', 'screen' => 'competence_level', 'screen_name' => 'Nível da Competência', 'role_name' => 'Excluir' ] );
        Role::create( [ 'role' => 'read', 'screen' => 'competence_level', 'screen_name' => 'Nível da Competência', 'role_name' => 'Leitura' ] );
        Role::create( [ 'role' => 'create', 'screen' => 'competence_type', 'screen_name' => 'Tipo de Competência', 'role_name' => 'Adicionar' ] );
        Role::create( [ 'role' => 'update', 'screen' => 'competence_type', 'screen_name' => 'Tipo de Competência', 'role_name' => 'Editar' ] );
        Role::create( [ 'role' => 'delete', 'screen' => 'competence_type', 'screen_name' => 'Tipo de Competência', 'role_name' => 'Excluir' ] );
        Role::create( [ 'role' => 'read', 'screen' => 'competence_type', 'screen_name' => 'Tipo de Competência', 'role_name' => 'Leitura' ] );
        Role::create( [ 'role' => 'create', 'screen' => 'grade', 'screen_name' => 'Grau', 'role_name' => 'Adicionar' ] );
        Role::create( [ 'role' => 'update', 'screen' => 'grade', 'screen_name' => 'Grau', 'role_name' => 'Editar' ] );
        Role::create( [ 'role' => 'delete', 'screen' => 'grade', 'screen_name' => 'Grau', 'role_name' => 'Excluir' ] );
        Role::create( [ 'role' => 'read', 'screen' => 'grade', 'screen_name' => 'Grau', 'role_name' => 'Leitura' ] );
        Role::create( [ 'role' => 'create', 'screen' => 'grade_course', 'screen_name' => 'Cursos', 'role_name' => 'Adicionar' ] );
        Role::create( [ 'role' => 'update', 'screen' => 'grade_course', 'screen_name' => 'Cursos', 'role_name' => 'Editar' ] );
        Role::create( [ 'role' => 'delete', 'screen' => 'grade_course', 'screen_name' => 'Cursos', 'role_name' => 'Excluir' ] );
        Role::create( [ 'role' => 'read', 'screen' => 'grade_course', 'screen_name' => 'Cursos', 'role_name' => 'Leitura' ] );
        Role::create( [ 'role' => 'create', 'screen' => 'language', 'screen_name' => 'Idioma', 'role_name' => 'Adicionar' ] );
        Role::create( [ 'role' => 'update', 'screen' => 'language', 'screen_name' => 'Idioma', 'role_name' => 'Editar' ] );
        Role::create( [ 'role' => 'delete', 'screen' => 'language', 'screen_name' => 'Idioma', 'role_name' => 'Excluir' ] );
        Role::create( [ 'role' => 'read', 'screen' => 'language', 'screen_name' => 'Idioma', 'role_name' => 'Leitura' ] );
        Role::create( [ 'role' => 'create', 'screen' => 'position', 'screen_name' => 'Posição', 'role_name' => 'Adicionar' ] );
        Role::create( [ 'role' => 'update', 'screen' => 'position', 'screen_name' => 'Posição', 'role_name' => 'Editar' ] );
        Role::create( [ 'role' => 'delete', 'screen' => 'position', 'screen_name' => 'Posição', 'role_name' => 'Excluir' ] );
        Role::create( [ 'role' => 'read', 'screen' => 'position', 'screen_name' => 'Posição', 'role_name' => 'Leitura' ] );
        Role::create( [ 'role' => 'create', 'screen' => 'position_description', 'screen_name' => 'Descrição de Posição', 'role_name' => 'Adicionar' ] );
        Role::create( [ 'role' => 'update', 'screen' => 'position_description', 'screen_name' => 'Descrição de Posição', 'role_name' => 'Editar' ] );
        Role::create( [ 'role' => 'delete', 'screen' => 'position_description', 'screen_name' => 'Descrição de Posição', 'role_name' => 'Excluir' ] );
        Role::create( [ 'role' => 'read', 'screen' => 'position_description', 'screen_name' => 'Descrição de Posição', 'role_name' => 'Leitura' ] );
        Role::create( [ 'role' => 'validate', 'screen' => 'position_description', 'screen_name' => 'Descrição de Posição', 'role_name' => 'Validar' ] );
        Role::create( [ 'role' => 'exportxlsx', 'screen' => 'position_description', 'screen_name' => 'Descrição de Posição', 'role_name' => 'Exportar Excel' ] );
        Role::create( [ 'role' => 'admin', 'screen' => 'role', 'screen_name' => 'Permissões', 'role_name' => 'Administrador' ] );
        Role::create( [ 'role' => 'admin', 'screen' => 'config', 'screen_name' => 'Parâmetros', 'role_name' => 'Administrador' ] );
        Role::create( [ 'role' => 'create', 'screen' => 'user', 'screen_name' => 'Usuários', 'role_name' => 'Adicionar' ] );
        Role::create( [ 'role' => 'update', 'screen' => 'user', 'screen_name' => 'Usuários', 'role_name' => 'Editar' ] );
        Role::create( [ 'role' => 'delete', 'screen' => 'user', 'screen_name' => 'Usuários', 'role_name' => 'Excluir' ] );
        Role::create( [ 'role' => 'read', 'screen' => 'user', 'screen_name' => 'Usuários', 'role_name' => 'Leitura' ] ,
        );
    }
}


