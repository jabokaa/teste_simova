<?php

//  criando funções para o twig

use app\functions\Flash;

$teste = new \Twig\TwigFunction("teste", function($data) {
    echo($data);
});

$count = new \Twig\TwigFunction("count", function($data) {
    return (count($data));
});

$qtdPages = new \Twig\TwigFunction("qtdPages", function($totlaElements, $qtdElementsPerPage) {
    $qtdPages = (ceil($totlaElements / $qtdElementsPerPage));
    if($qtdPages == 0) {
        $qtdPages = 1;
    }
    return ($qtdPages);
});

$flash = new \Twig\TwigFunction("flash", function() {
    echo Flash::showMenssagem();
});

return [
    $teste,
    $count,
    $qtdPages,
    $flash
];