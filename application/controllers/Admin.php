<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Carrega os models necessários
        $this->load->model('Disciplina_model');
        $this->load->model('Aluno_model');
        $this->load->model('Notas_model');
        $this->load->helper('url');
        $this->load->library('session');
    }

    /* ----------------------- 
       Gestão de Disciplinas
       ----------------------- */

    // Tela para listar disciplinas
    public function disciplinas()
    {
        $data['disciplinas'] = $this->Disciplina_model->getDisciplinas();
        $content = $this->load->view('admin/disciplinas', $data, TRUE);
        $this->load->view('layouts/main', ['title' => 'Disciplinas', 'content' => $content]);
    }

    // Método para adicionar disciplina (exibe o formulário e processa o POST)
    public function adicionar_disciplina()
    {
        if ($this->input->post()) {
            $data = [
                'nome' => $this->input->post('nome')
            ];
            $this->Disciplina_model->adicionar($data);
            $this->session->set_flashdata('success', 'Disciplina adicionada com sucesso.');
            redirect(base_url('admin/disciplinas'));
        } else {
            // Exibe formulário de adição
            $this->load->view('admin/adicionar_disciplina');
        }
    }

    // Método para atualizar disciplina
    public function atualizar_disciplina($id)
    {
        if ($this->input->post()) {
            $data = [
                'nome' => $this->input->post('nome')
            ];
            $this->Disciplina_model->atualizar($id, $data);
            $this->session->set_flashdata('success', 'Disciplina atualizada com sucesso.');
            redirect(base_url('admin/disciplinas'));
        } else {
            $data['disciplina'] = $this->Disciplina_model->getDisciplinaById($id);
            if (!$data['disciplina']) {
                $this->session->set_flashdata('error', 'Disciplina não encontrada.');
                redirect(base_url('admin/disciplinas'));
            }
            $this->load->view('admin/atualizar_disciplina', $data);
        }
    }

    // Método para excluir disciplina
    public function excluir_disciplina($id)
    {
        $this->Disciplina_model->excluir($id);
        $this->session->set_flashdata('success', 'Disciplina excluída com sucesso.');
        redirect(base_url('admin/disciplinas'));
    }

    /* ----------------------- 
       Lançamento de Notas
       ----------------------- */

    // Tela para lançar notas para um aluno específico
    public function lancar_notas($aluno_id)
    {
        // Busca o aluno e as disciplinas para o lançamento
        $data['aluno'] = $this->Aluno_model->getAlunoById($aluno_id);
        if (!$data['aluno']) {
            $this->session->set_flashdata('error', 'Aluno não encontrado.');
            redirect(base_url('aluno'));
        }
        // Todas as disciplinas para permitir selecionar ou lançar a nota
        $data['disciplinas'] = $this->Disciplina_model->getDisciplinas();
        // Busca as notas já lançadas para esse aluno
        $data['notas'] = $this->Notas_model->get_notas_por_aluno($aluno_id);
        $content = $this->load->view('admin/lancar_notas', $data, TRUE);
        $this->load->view('layouts/main', ['title' => 'Lançar Notas', 'content' => $content]);
    }

    // Processa o lançamento de notas (inserção ou atualização)
    public function salvar_notas($aluno_id)
    {
        if ($this->input->post()) {
            // Recebe os arrays enviados pelo formulário
            $disciplinas = $this->input->post('disciplina'); // array de IDs das disciplinas
            $notas = $this->input->post('nota'); // array de notas correspondentes

            // Validação: se alguma nota não for numérica, seta mensagem de erro e redireciona
            foreach ($notas as $nota_valor) {
                if (!is_numeric($nota_valor)) {
                    $this->session->set_flashdata('error', 'A nota deve ser um número.');
                    redirect(base_url('admin/lancar_notas/' . $aluno_id));
                    return;
                }
            }

            // Percorre cada disciplina e processa a nota correspondente
            foreach ($disciplinas as $key => $disciplina_id) {
                $nota_valor = $notas[$key];
                // Verifica se já existe uma nota para esse aluno e disciplina
                $nota_existente = $this->Notas_model->get_nota($aluno_id, $disciplina_id);

                if ($nota_existente) {
                    // Se existe, atualiza a nota
                    $this->Notas_model->atualizar_nota($nota_existente->id, ['nota' => $nota_valor]);
                } else {
                    // Se não existe, insere uma nova nota
                    $data = [
                        'aluno_id'      => $aluno_id,
                        'disciplina_id' => $disciplina_id,
                        'nota'          => $nota_valor
                    ];
                    $this->Notas_model->adicionar($data);
                }
            }
            $this->session->set_flashdata('success', 'Notas atualizadas com sucesso.');
            redirect(base_url('admin/lancar_notas/' . $aluno_id));
        } else {
            $this->session->set_flashdata('error', 'Dados inválidos.');
            redirect(base_url('admin/lancar_notas/' . $aluno_id));
        }
    }

    public function config()
    {
        $content = $this->load->view('admin/config', null, TRUE);
        $this->load->view('layouts/main', ['title' => 'Configurações', 'content' => $content]);
    }


    public function inserir_dados_fake()
    {
        // --- Inserir disciplinas ---

        // Reinicia as tabelas para garantir um ambiente limpo
        $this->db->query("TRUNCATE TABLE notas, disciplinas, alunos CASCADE");


        // Insere as disciplinas
        $disciplinas_fake = [
            ['nome' => 'Matemática'],
            ['nome' => 'Português'],
            ['nome' => 'História'],
            ['nome' => 'Geografia'],
            ['nome' => 'Ciências']
        ];
        foreach ($disciplinas_fake as $d) {
            $this->Disciplina_model->adicionar($d);
        }

        // Insere alunos fake e armazena os IDs gerados
        $alunos_fake = [
            ['nome' => 'Aluno Fake 1', 'matricula' => 'F001'],
            ['nome' => 'Aluno Fake 2', 'matricula' => 'F002'],
            ['nome' => 'Aluno Fake 3', 'matricula' => 'F003']
        ];
        $aluno_ids = [];
        foreach ($alunos_fake as $a) {
            $this->Aluno_model->adicionar($a);
            $aluno_ids[] = $this->db->insert_id();  // armazena o ID gerado
        }
        // Agora, insere as notas usando os IDs reais dos alunos

        $this->session->set_flashdata('success', 'Dados fake inseridos com sucesso.');
        redirect(base_url('admin/config'));
    }
    public function reiniciar_dados()
    {
        // Trunca as tabelas com CASCADE para evitar erros de chave estrangeira
        $this->db->query("TRUNCATE TABLE notas, disciplinas, alunos CASCADE");
        $this->session->set_flashdata('success', 'Todas as tabelas foram reiniciadas com sucesso.');
        redirect(base_url('admin/config'));
    }
}
