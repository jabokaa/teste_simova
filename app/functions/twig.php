<?php

//  criando funções para o twig
$teste = new \Twig\TwigFunction("teste", function($data) {
    echo($data);
});

return [
    $teste,
];