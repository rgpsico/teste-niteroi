<!-- application/views/admin/config.php -->
<h2>Tela de Configurações</h2>
<p>Aqui você pode inserir dados fake para testar o sistema.</p>

<!-- Botão para inserir dados fake -->
<a href="<?php echo base_url('admin/inserir_dados_fake'); ?>" class="btn btn-primary">
    Inserir Dados Fake
</a>

<!-- Botão para reiniciar todas as tabelas -->
<a href="<?php echo base_url('admin/reiniciar_dados'); ?>" class="btn btn-danger"
    onclick="return confirm('Tem certeza que deseja reiniciar todas as tabelas? Todos os dados serão perdidos!')">
    Reiniciar Dados
</a>