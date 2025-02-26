<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Jenssegers\Blade\Blade;
use Illuminate\Container\Container;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Filesystem\Filesystem;

/**
 * Subclasse do Container para evitar erro "Call to undefined method terminating()".
 */
class MyContainer extends Container
{
    public function terminating($callback = null)
    {
        // Este método é chamado internamente pelo ViewServiceProvider,
        // mas não existe por padrão em Container. Deixamos vazio.
    }
}

/**
 * Biblioteca de integração do Blade no CodeIgniter.
 */
class Blade_lib
{
    protected $blade;

    public function __construct()
    {
        // Caminhos das views e do cache
        $views = APPPATH . 'views';
        $cache = APPPATH . 'cache/blade';

        // Garante que a pasta de cache exista
        if (!file_exists($cache)) {
            mkdir($cache, 0777, true);
        }

        // Instancia nosso container customizado
        $container = new MyContainer;

        // Faz o binding de "blade.compiler" no container
        $container->singleton('blade.compiler', function () use ($cache) {
            return new BladeCompiler(new Filesystem, $cache);
        });

        // Cria a instância do Blade, passando o container customizado
        $this->blade = new Blade($views, $cache, $container);
    }

    /**
     * Renderiza uma view usando o Blade.
     *
     * @param string $view  Nome do arquivo .blade.php (sem extensão)
     * @param array  $data  Dados a serem repassados para a view
     */
    public function render($view, $data = [])
    {
        echo $this->blade->render($view, $data);
    }
}
