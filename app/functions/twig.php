<?php

//  criando funções para o twig
$teste = new \Twig\TwigFunction("teste", function($data) {
    echo($data);
});

$count = new \Twig\TwigFunction("count", function($data) {
    return (count($data));
});

$qtdPages = new \Twig\TwigFunction("qtdPages", function($totlaElements, $qtdElementsPerPage) {
    return (ceil($totlaElements / $qtdElementsPerPage));
});

return [
    $teste,
    $count,
    $qtdPages
];