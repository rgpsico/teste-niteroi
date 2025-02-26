<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aluno extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Aluno_model');
        $this->load->model('Notas_model');
        $this->load->helper('url'); // para usar base_url()
        $this->load->library('session'); // para usar flashdata
    }

    // Método para listar alunos e suas notas
    public function index()
    {
        // Busca todos os alunos
        $alunos = $this->Aluno_model->getAlunos();

        // Para cada aluno, busca as notas e organiza em um array associativo
        $notas_por_aluno = array();
        foreach ($alunos as $aluno) {
            $notas_por_aluno[$aluno->id] = $this->Notas_model->get_notas_por_aluno($aluno->id);
        }

        // Prepara os dados para a view
        $data = [
            'title'          => 'Lista de Alunos',
            'alunos'         => $alunos,
            'notas_por_aluno' => $notas_por_aluno
        ];

        // Carrega a view "pages/home" dentro do layout principal
        $content = $this->load->view('pages/home', $data, TRUE);
        $this->load->view('layouts/main', ['title' => 'Página Inicial', 'content' => $content]);
    }

    // Método para adicionar um novo aluno
    public function adicionar()
    {
        if ($this->input->post()) {
            // Recebe os dados do formulário
            $data = [
                'nome'      => $this->input->post('nome'),
                'matricula' => $this->input->post('matricula')
            ];

            if ($this->Aluno_model->matricula_existe($data['matricula'])) {
                $this->session->set_flashdata('error', 'A matrícula informada já existe.');
                redirect(base_url());
            }
            // Insere o aluno (método a ser implementado no model)
            $this->Aluno_model->adicionar($data);

            // Define uma mensagem de sucesso
            $this->session->set_flashdata('success', 'Aluno adicionado com sucesso.');
            redirect(base_url('aluno'));
        } else {
            // Exibe o formulário de cadastro
            $this->load->view('pages/adicionar_aluno');
        }
    }

    // Método para atualizar os dados de um aluno
    public function atualizar($id)
    {
        if ($this->input->post()) {
            // Dados recebidos do formulário de edição
            $data = [
                'nome'      => $this->input->post('nome'),
                'matricula' => $this->input->post('matricula')
            ];
            $this->Aluno_model->atualizar($id, $data);
            $this->session->set_flashdata('success', 'Aluno atualizado com sucesso.');
            redirect(base_url('aluno'));
        } else {
            // Busca os dados do aluno para preencher o formulário
            $data['aluno'] = $this->Aluno_model->getAlunoById($id);
            if (!$data['aluno']) {
                $this->session->set_flashdata('error', 'Aluno não encontrado.');
                redirect(base_url('aluno'));
            }
            $this->load->view('pages/atualizar_aluno', $data);
        }
    }

    // Método para excluir um aluno
    public function excluir($id)
    {
        // Exclui as notas associadas ao aluno
        $this->Notas_model->excluir_por_aluno($id);

        // Exclui o aluno
        $this->Aluno_model->excluir($id);
        $this->session->set_flashdata('success', 'Aluno e suas notas foram excluídos com sucesso.');
        redirect(base_url('aluno'));
    }
}
