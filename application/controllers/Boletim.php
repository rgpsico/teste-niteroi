<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Boletim extends CI_Controller
{

    protected $pdf;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Aluno_model');
        $this->load->model('Notas_model');
        // Carrega a biblioteca FPDF (ajuste o nome se for diferente)
        //$this->load->library('fpdf_lib');

    }

    public function gerar_pdf($id)
    {

        // Busca os dados do aluno
        $aluno = $this->Aluno_model->getAlunoById($id);
        if (!$aluno) {
            // Define uma mensagem de erro na sessão (flashdata)
            $this->session->set_flashdata('error', 'Aluno não encontrado.');
            // Redireciona para a tela inicial (ajuste conforme sua rota padrão)
            redirect(base_url());
        }
        // Busca as notas do aluno
        $notas = $this->Notas_model->get_notas_por_aluno($id);

        // Cria uma instância do FPDF (ajuste conforme sua biblioteca)
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Boletim Escolar', 0, 1, 'C');
        $pdf->Ln(5);

        // Exibe os dados do aluno
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Nome: ' . $aluno->nome, 0, 1);
        $pdf->Cell(0, 10, utf8_decode('Matrícula: ') . $aluno->matricula, 0, 1);
        $pdf->Ln(5);

        // Tabela de notas
        if (!empty($notas)) {
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(100, 10, 'Disciplina', 1, 0, 'C');
            $pdf->Cell(40, 10, 'Nota', 1, 1, 'C');
            $pdf->SetFont('Arial', '', 12);
            foreach ($notas as $nota) {
                $pdf->Cell(100, 10, utf8_decode($nota->disciplina), 1, 0);
                $pdf->Cell(40, 10, $nota->nota, 1, 1, 'C');
            }
        } else {
            $pdf->Cell(0, 10, 'Nenhuma nota registrada para este aluno.', 0, 1);
        }

        // Exibe o PDF no navegador
        $pdf->Output('I', 'boletim_' . $aluno->id . '.pdf');
    }
}
