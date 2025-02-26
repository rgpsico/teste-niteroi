<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Aluno_model');
        $this->load->model('Notas_model');
        $this->load->helper('url');
    }

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
            'title'         => 'Lista de Alunos',
            'alunos'        => $alunos,
            'notas_por_aluno' => $notas_por_aluno
        ];

        // Carrega a view "pages/home" dentro do layout principal
        $content = $this->load->view('pages/home', $data, TRUE);
        $this->load->view('layouts/main', ['title' => 'Página Inicial', 'content' => $content]);
    }
}
