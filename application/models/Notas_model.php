<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notas_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Carrega a conexão com o banco de dados
    }



    public function excluir_por_aluno($aluno_id)
    {
        $this->db->where('aluno_id', $aluno_id);
        return $this->db->delete('notas');
    }


    /**
     * Retorna as notas de um aluno, com o nome da disciplina.
     * @param int $aluno_id
     * @return array Array de objetos com id da nota, nota e nome da disciplina.
     */
    public function get_notas_por_aluno($aluno_id)
    {
        $this->db->select('notas.id, notas.nota, notas.disciplina_id, disciplinas.nome AS disciplina');
        $this->db->from('notas');
        $this->db->join('disciplinas', 'disciplinas.id = notas.disciplina_id', 'left');
        $this->db->where('notas.aluno_id', $aluno_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_nota($aluno_id, $disciplina_id)
    {
        $this->db->where('aluno_id', $aluno_id);
        $this->db->where('disciplina_id', $disciplina_id);
        $query = $this->db->get('notas');
        return $query->row();
    }



    public function adicionar($data)
    {
        // Opcional: verifica se já existe uma nota para o mesmo aluno e disciplina
        $this->db->where('aluno_id', $data['aluno_id']);
        $this->db->where('disciplina_id', $data['disciplina_id']);
        $query = $this->db->get('notas');
        if ($query->num_rows() > 0) {
            // Se já existe, você pode optar por não inserir (ou atualizar)
            return false;
        }
        return $this->db->insert('notas', $data);
    }



    public function atualizar_nota($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('notas', $data);
    }

    /**
     * Retorna todos os alunos cadastrados
     */
    public function getAlunos()
    {
        $query = $this->db->get('Notas'); // SELECT * FROM notas
        return $query->result(); // Retorna os resultados como um array de objetos
    }
}
