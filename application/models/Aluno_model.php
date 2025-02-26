<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aluno_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Carrega a conexão com o banco de dados
    }


    /**
     * Retorna os dados do aluno e suas notas, juntando as tabelas alunos, notas e disciplinas.
     * @param int $aluno_id
     * @return array Array de objetos com os dados do aluno e as notas
     */
    public function get_aluno_com_notas($aluno_id)
    {
        $this->db->select('
            alunos.id,
            alunos.nome,
            alunos.matricula,
            notas.nota,
            disciplinas.nome AS disciplina
        ');
        $this->db->from('alunos');
        // Faz o JOIN com a tabela notas (left join para que mesmo sem notas o aluno seja retornado)
        $this->db->join('notas', 'notas.aluno_id = alunos.id', 'left');
        // Faz o JOIN com a tabela disciplinas para obter o nome da disciplina
        $this->db->join('disciplinas', 'disciplinas.id = notas.disciplina_id', 'left');
        $this->db->where('alunos.id', $aluno_id);
        $query = $this->db->get();
        return $query->result();
    }




    // Retorna todos os alunos
    public function getAlunos()
    {
        $query = $this->db->get('alunos');
        return $query->result();
    }

    // Retorna um aluno pelo ID
    public function getAlunoById($id)
    {
        $query = $this->db->get_where('alunos', ['id' => $id]);
        return $query->row();
    }

    // Insere um novo aluno
    public function adicionar($data)
    {
        return $this->db->insert('alunos', $data);
    }

    // Atualiza os dados de um aluno
    public function atualizar($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('alunos', $data);
    }

    // Exclui um aluno
    public function excluir($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('alunos');
    }

    public function matricula_existe($matricula)
    {
        $this->db->where('matricula', $matricula);
        $query = $this->db->get('alunos');
        return ($query->num_rows() > 0);
    }
}
