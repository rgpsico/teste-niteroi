<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php echo isset($title) ? $title : 'Título Padrão'; ?></title>
    <!-- Inclua os estilos do Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Outros CSS customizados -->
    <link rel="stylesheet" href="">
</head>

<body>

    <!-- Navbar com Hamburger, logo e menus -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!-- Logo e nome da aplicação -->
        <a class="navbar-brand" href="#">
            <img src="" width="30" height="30" class="d-inline-block align-top" alt="Logo">
            Minha Aplicação
        </a>
        <!-- Botão Hamburger para exibição em telas menores -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Itens do Menu -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ml-auto">
                <!-- Link simples -->
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <!-- Outro link -->
                <li class="nav-item">
                    <a class="nav-link" href="#">Sobre</a>
                </li>
                <!-- Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Serviços
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Serviço 1</a>
                        <a class="dropdown-item" href="#">Serviço 2</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Outro Serviço</a>
                    </div>
                </li>
                <!-- Link desabilitado -->
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Contato</a>
                </li>
            </ul>
        </div>
    </nav>

    <hr>

    <section class="container my-4">
        <!-- Conteúdo da view parcial -->
        <?php echo isset($content) ? $content : ''; ?>
    </section>

    <footer class="bg-light text-center py-3">
        <hr>
        <p>&copy; <?php echo date('Y'); ?> - Meu Rodapé</p>
    </footer>

    <!-- Modal Genérico (Exemplo) -->
    <div class="modal fade" id="modalGenerico" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Título do Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Conteúdo do modal.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary">Salvar alterações</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts: jQuery, Popper.js e Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Outros scripts customizados -->
    <script src=""></script>
</body>

</html>