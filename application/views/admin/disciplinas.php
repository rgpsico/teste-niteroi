<h2>Gerenciar Disciplinas</h2>

<!-- Botão para abrir o modal de adicionar disciplina -->
<button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addDisciplinaModal">
    Adicionar Disciplina
</button>

<!-- Modal para Adicionar Disciplina -->
<div class="modal fade" id="addDisciplinaModal" tabindex="-1" role="dialog" aria-labelledby="addDisciplinaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo base_url('admin/adicionar_disciplina'); ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDisciplinaModalLabel">Adicionar Disciplina</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nome">Nome da Disciplina:</label>
                        <input type="text" class="form-control" name="nome" id="nome" required>
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
    <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
<?php endif; ?>
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
<?php endif; ?>

<table class="table table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($disciplinas as $disciplina): ?>
            <tr>
                <td><?php echo $disciplina->id; ?></td>
                <td><?php echo $disciplina->nome; ?></td>
                <td>
                    <!-- Botão Editar -->
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editDisciplinaModal-<?php echo $disciplina->id; ?>">Editar</button>
                    <!-- Botão Excluir -->
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteDisciplinaModal-<?php echo $disciplina->id; ?>">Excluir</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modais para cada disciplina -->
<?php foreach ($disciplinas as $disciplina): ?>
    <!-- Modal Editar Disciplina -->
    <div class="modal fade" id="editDisciplinaModal-<?php echo $disciplina->id; ?>" tabindex="-1" role="dialog" aria-labelledby="editDisciplinaModalLabel-<?php echo $disciplina->id; ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?php echo base_url('admin/atualizar_disciplina/' . $disciplina->id); ?>" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDisciplinaModalLabel-<?php echo $disciplina->id; ?>">Editar Disciplina</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nome-<?php echo $disciplina->id; ?>">Nome:</label>
                            <input type="text" class="form-control" id="nome-<?php echo $disciplina->id; ?>" name="nome" value="<?php echo $disciplina->nome; ?>" required>
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

    <!-- Modal Excluir Disciplina -->
    <div class="modal fade" id="deleteDisciplinaModal-<?php echo $disciplina->id; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteDisciplinaModalLabel-<?php echo $disciplina->id; ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteDisciplinaModalLabel-<?php echo $disciplina->id; ?>">Confirmar Exclusão</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Você tem certeza que deseja excluir a disciplina <strong><?php echo $disciplina->nome; ?></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <a href="<?php echo base_url('admin/excluir_disciplina/' . $disciplina->id); ?>" class="btn btn-danger">Excluir</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>