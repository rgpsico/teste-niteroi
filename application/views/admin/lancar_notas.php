<h2>Lançar Notas para <?php echo $aluno->nome; ?></h2>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
<?php endif; ?>
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
<?php endif; ?>

<?php
// Cria um array associativo para facilitar a busca das notas existentes por disciplina
$notas_existentes = array();
if (isset($notas) && !empty($notas)) {
    foreach ($notas as $n) {
        $notas_existentes[$n->disciplina_id] = $n->nota;
    }
}
?>

<form action="<?php echo base_url('admin/salvar_notas/' . $aluno->id); ?>" method="post">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Disciplina</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($disciplinas as $disciplina): ?>
                <tr>
                    <td><?php echo $disciplina->nome; ?></td>
                    <td>
                        <!-- Campo oculto com o id da disciplina -->
                        <input type="hidden" name="disciplina[]" value="<?php echo $disciplina->id; ?>">
                        <!-- Input para a nota, pré-preenchido se existir -->
                        <input type="text" name="nota[]" class="form-control" placeholder="Digite a nota" value="<?php echo isset($notas_existentes[$disciplina->id]) ? $notas_existentes[$disciplina->id] : ''; ?>">
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button type="submit" class="btn btn-primary">Salvar Notas</button>
</form>