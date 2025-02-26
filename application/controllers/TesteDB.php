<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TesteDB extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Carrega a biblioteca de banco de dados
        $this->load->database();
    }

    public function index()
    {
        // Apenas para ter algo na página inicial, se quiser
        echo "Controller TesteDB - Acesse /inserir e /listar para ver exemplos.";
    }

    public function inserir()
    {
        // Exemplo: vamos inserir um aluno na tabela 'alunos'
        // Certifique-se de que a tabela 'alunos' exista no banco 'escola'.
        // CREATE TABLE alunos (id SERIAL PRIMARY KEY, nome VARCHAR(100), matricula VARCHAR(20));

        $dados = array(
            'nome'      => 'Maria da Silva',
            'matricula' => '2023001'
        );

        // Método 1: Usar Query Builder
        $this->db->insert('alunos', $dados);

        // Verificar se inseriu
        if ($this->db->affected_rows() > 0) {
            echo "Aluno inserido com sucesso!";
        } else {
            echo "Erro ao inserir aluno.";
        }
    }

    public function listar()
    {
        // Exemplo: SELECT * FROM alunos
        // Método 1: Query Builder
        $query = $this->db->get('alunos');
        $result = $query->result(); // retorna array de objetos

        echo "<pre>";
        print_r($result);
        echo "</pre>";
    }

    public function inserir_query_simples()
    {
        // Método 2: Usar query pura
        $sql = "INSERT INTO alunos (nome, matricula) VALUES ('João Pereira', '2023002')";
        $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            echo "Aluno inserido via query pura!";
        } else {
            echo "Erro ao inserir via query pura.";
        }
    }

    public function listar_query_simples()
    {
        // Método 2: Query pura
        $sql = "SELECT * FROM alunos";
        $query = $this->db->query($sql);
        $result = $query->result();

        echo "<pre>";
        print_r($result);
        echo "</pre>";
    }
}
