<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Disciplina_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Retorna todas as disciplinas
    public function getDisciplinas()
    {
        $query = $this->db->get('disciplinas');
        return $query->result();
    }

    // Retorna uma disciplina pelo ID
    public function getDisciplinaById($id)
    {
        $query = $this->db->get_where('disciplinas', ['id' => $id]);
        return $query->row();
    }

    // Insere uma nova disciplina
    public function adicionar($data)
    {
        return $this->db->insert('disciplinas', $data);
    }

    // Atualiza uma disciplina
    public function atualizar($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('disciplinas', $data);
    }

    // Exclui uma disciplina
    public function excluir($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('disciplinas');
    }
}
