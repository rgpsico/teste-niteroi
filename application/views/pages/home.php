<!-- application/views/pages/home.php -->
<h2 class="mt-3">Lista de Alunos</h2>

<!-- Botão para adicionar aluno -->
<button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addAlunoModal">
    Adicionar Aluno
</button>

<!-- Modal para adicionar aluno -->
<div class="modal fade" id="addAlunoModal" tabindex="-1" role="dialog" aria-labelledby="addAlunoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo base_url('aluno/adicionar'); ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAlunoModalLabel">Adicionar Novo Aluno</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Campos do formulário -->
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" class="form-control" name="nome" id="nome" required>
                    </div>
                    <div class="form-group">
                        <label for="matricula">Matrícula:</label>
                        <input type="text" class="form-control" name="matricula" id="matricula" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Exibe mensagens de erro ou sucesso -->
<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
        <?php echo $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>

<!-- Tabela de alunos -->
<?php if (!empty($alunos)) : ?>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Matrícula</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alunos as $aluno): ?>
                <tr>
                    <td><?php echo $aluno->id; ?></td>
                    <td><?php echo $aluno->nome; ?></td>
                    <td><?php echo $aluno->matricula; ?></td>
                    <td>
                        <!-- Botão Editar -->
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal-<?php echo $aluno->id; ?>">
                            Editar
                        </button>
                        <!-- Botão Boletim -->
                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#boletimModal-<?php echo $aluno->id; ?>">
                            Boletim
                        </button>
                        <!-- Botão Lançar Notas -->
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#lancarNotasModal-<?php echo $aluno->id; ?>">
                            Lançar Notas
                        </button>
                        <!-- Botão Excluir -->
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal-<?php echo $aluno->id; ?>">
                            Excluir
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Modais para cada aluno -->
    <?php foreach ($alunos as $aluno): ?>

        <!-- Modal Editar -->
        <div class="modal fade" id="editModal-<?php echo $aluno->id; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel-<?php echo $aluno->id; ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="<?php echo base_url('aluno/atualizar/' . $aluno->id); ?>" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel-<?php echo $aluno->id; ?>">Editar Aluno</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Campos do formulário de edição -->
                            <div class="form-group">
                                <label for="nome-<?php echo $aluno->id; ?>">Nome:</label>
                                <input type="text" class="form-control" id="nome-<?php echo $aluno->id; ?>" name="nome" value="<?php echo $aluno->nome; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="matricula-<?php echo $aluno->id; ?>">Matrícula:</label>
                                <input type="text" class="form-control" id="matricula-<?php echo $aluno->id; ?>" name="matricula" value="<?php echo $aluno->matricula; ?>" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Boletim -->
        <div class="modal fade" id="boletimModal-<?php echo $aluno->id; ?>" tabindex="-1" role="dialog" aria-labelledby="boletimModalLabel-<?php echo $aluno->id; ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="boletimModalLabel-<?php echo $aluno->id; ?>">Boletim - <?php echo $aluno->nome; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php if (isset($notas_por_aluno[$aluno->id]) && !empty($notas_por_aluno[$aluno->id])): ?>
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Disciplina</th>
                                        <th>Nota</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($notas_por_aluno[$aluno->id] as $nota): ?>
                                        <tr>
                                            <td><?php echo $nota->disciplina; ?></td>
                                            <td><?php echo $nota->nota; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>Não há notas registradas para este aluno.</p>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <!-- Botão para imprimir o boletim -->
                        <button type="button" class="btn btn-secondary" onclick="window.open('<?php echo base_url('boletim/gerar_pdf/' . $aluno->id); ?>','_blank');">
                            Imprimir Boletim
                        </button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Lançar Notas -->
        <!-- Modal Lançar Notas para cada aluno -->
        <div class="modal fade" id="lancarNotasModal-<?php echo $aluno->id; ?>" tabindex="-1" role="dialog" aria-labelledby="lancarNotasModalLabel-<?php echo $aluno->id; ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <?php
                    // Cria um array associativo com chave = disciplina_id e valor = nota para o aluno atual
                    $notas_aluno = array();
                    if (isset($notas_por_aluno[$aluno->id]) && !empty($notas_por_aluno[$aluno->id])) {
                        foreach ($notas_por_aluno[$aluno->id] as $nota) {
                            $notas_aluno[$nota->disciplina_id] = $nota->nota;
                        }
                    }
                    ?>
                    <form action="<?php echo base_url('admin/salvar_notas/' . $aluno->id); ?>" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="lancarNotasModalLabel-<?php echo $aluno->id; ?>">Lançar Notas para <?php echo $aluno->nome; ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Tabela listando as disciplinas e campos para as notas -->
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
                                                <input type="hidden" name="disciplina[]" value="<?php echo $disciplina->id; ?>">
                                                <input type="text" name="nota[]" class="form-control" placeholder="Digite a nota" value="<?php echo isset($notas_aluno[$disciplina->id]) ? $notas_aluno[$disciplina->id] : ''; ?>">
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar Notas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Excluir -->
        <div class="modal fade" id="deleteModal-<?php echo $aluno->id; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel-<?php echo $aluno->id; ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel-<?php echo $aluno->id; ?>">Confirmar Exclusão</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Você tem certeza que deseja excluir o aluno <strong><?php echo $aluno->nome; ?></strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <a href="<?php echo base_url('aluno/excluir/' . $aluno->id); ?>" class="btn btn-danger">Excluir</a>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>

<?php else : ?>
    <div class="alert alert-warning" role="alert">
        Nenhum aluno encontrado.
    </div>
<?php endif; ?>