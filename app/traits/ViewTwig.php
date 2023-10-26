<?php
namespace app\traits;

use app\src\Load;

trait ViewTwig
{
    protected $twig;

    /**
     * Carrega o twig
     * @return void
     */
    public function twig(): void
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../views');
        $this->twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);
    }

    /**
     * Carrega o twig + funções
     * @return void
     */
    protected function load(): void
    {
        $this->twig();
        $this->functions();
    }

    /**
     * Renderiza a view
     * @param string $view
     * @param array $data
     */
    protected function view(string $view, array $data = [])
    {
        $this->load();
        $template = $this->twig->load(str_replace('.', '/', $view) . '.html');
        return $template->display($data);
    }

    /**
     * Carrega as funções do twig
     * @return void
     */
    protected function functions() {
        $functions = Load::file('/app/functions/twig.php');

        foreach( $functions as $function ) {
            $this->twig->addFunction($function);
        }
    }
}