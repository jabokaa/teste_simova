<?php
    namespace app\traits;

    trait ViewTwig
    {
        protected $twig;
        public function twig()
        {
            $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../views');
            $this->twig = new \Twig\Environment($loader, [
                'cache' => false,
            ]);
        }

        protected function load()
        {
            $this->twig();
        }

        protected function view($view, $data = [])
        {
            $this->load();
            $template = $this->twig->load(str_replace('.', '/', $view) . '.html');
            return $template->display($data);
        }

        protected function functions() {

        }
    }