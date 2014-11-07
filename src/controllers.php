<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Goutte\Client;
use Entity\IGPM;
use Entity\SELIC;
use Entity\IPCA;
use Entity\CDI;
use Entity\Indicador;
use Malenki\Math\Stats;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {

    $s = new \Malenki\Math\Stats(array(1,2,4,2,6,4));
    var_dump(count($s));

    return $app['twig']->render('index.html', array());
})
->bind('homepage')
;

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html',
        'errors/'.substr($code, 0, 2).'x.html',
        'errors/'.substr($code, 0, 1).'xx.html',
        'errors/default.html',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});

$app->get('/cdi', function () use ($app) {
    $indicador    = new Indicador(4389);
    $ultimoIndice = $indicador->getUltimoIndiceXML();

    $data =
        $ultimoIndice->SERIE->DATA->ANO . '-' . $ultimoIndice->SERIE->DATA->MES . '-' . $ultimoIndice->SERIE->DATA->DIA;

    $data = new \DateTime($data);

    return $app['twig']->render(
        'indicador.html',
        array(
            'nome'    => 'CDI',
            'data'    => $data,
            'valor'   => $ultimoIndice->SERIE->VALOR,
            'tipo'    => 'diario',
            'unidade' => '%'
            )
    );
})
->bind('cdi')
;

$app->get('/ipca', function () use ($app) {
    $indicador    = new Indicador(433);
    $ultimoIndice = $indicador->getUltimoIndiceXML();

    $data =
        $ultimoIndice->SERIE->DATA->ANO . '-' . $ultimoIndice->SERIE->DATA->MES . '-' . $ultimoIndice->SERIE->DATA->DIA;

    $data = new \DateTime($data);

    return $app['twig']->render(
        'indicador.html',
        array(
            'nome'    => 'IPCA',
            'data'    => $data,
            'valor'   => $ultimoIndice->SERIE->VALOR,
            'tipo'    => 'mensal',
            'unidade' => '%'
            )
    );
})
->bind('ipca')
;

$app->get('/igpm', function () use ($app) {
    $indicador    = new Indicador(189);
    $ultimoIndice = $indicador->getUltimoIndiceXML();

    $data =
        $ultimoIndice->SERIE->DATA->ANO . '-' . $ultimoIndice->SERIE->DATA->MES . '-' . $ultimoIndice->SERIE->DATA->DIA;

    $data = new \DateTime($data);

    return $app['twig']->render(
        'indicador.html',
        array(
            'nome'    => 'IGPM',
            'data'    => $data,
            'valor'   => $ultimoIndice->SERIE->VALOR,
            'tipo'    => 'mensal',
            'unidade' => '%'
            )
    );
})
->bind('igpm')
;

$app->get('/selic', function () use ($app) {
    $indicador    = new Indicador(1178);
    $ultimoIndice = $indicador->getUltimoIndiceXML();

    $data =
        $ultimoIndice->SERIE->DATA->ANO . '-' . $ultimoIndice->SERIE->DATA->MES . '-' . $ultimoIndice->SERIE->DATA->DIA;

    $data = new \DateTime($data);

    return $app['twig']->render(
        'indicador.html',
        array(
            'nome'    => 'SELIC',
            'data'    => $data,
            'valor'   => $ultimoIndice->SERIE->VALOR,
            'tipo'    => 'diario',
            'unidade' => '%'
            )
    );
})
->bind('selic')
;

$app->get('/bovespa', function () use ($app) {
    $indicador    = new Indicador(7);
    $ultimoIndice = $indicador->getUltimoIndiceXML();

    $data =
        $ultimoIndice->SERIE->DATA->ANO . '-' . $ultimoIndice->SERIE->DATA->MES . '-' . $ultimoIndice->SERIE->DATA->DIA;

    $data = new \DateTime($data);

    return $app['twig']->render(
        'indicador.html',
        array(
            'nome'    => 'BOVESPA',
            'data'    => $data,
            'valor'   => $ultimoIndice->SERIE->VALOR,
            'tipo'    => 'diario',
            'unidade' => 'pontos'
            )
    );
})
->bind('bovespa')
;


$app->get('/cambio', function () use ($app) {
    //cambio venda
    $indicador    = new Indicador(1);
    $ultimoIndice = $indicador->getUltimoIndiceXML();

    $data =
        $ultimoIndice->SERIE->DATA->ANO . '-' . $ultimoIndice->SERIE->DATA->MES . '-' . $ultimoIndice->SERIE->DATA->DIA;
    $data = new \DateTime($data);

    //cambio compra
    $indicador     = new Indicador(10813);
    $ultimoIndiceC = $indicador->getUltimoIndiceXML();

    $dataC =
        $ultimoIndiceC->SERIE->DATA->ANO . '-' . $ultimoIndiceC->SERIE->DATA->MES . '-' . $ultimoIndiceC->SERIE->DATA->DIA;
    $dataC = new \DateTime($dataC);

    return $app['twig']->render(
        'cambio.html',
        array(
            'nome'        => 'Dólar americano',
            'dataVenda'   => $data,
            'valorVenda'  => $ultimoIndice->SERIE->VALOR,
            'tipo'        => 'diario',
            'dataCompra'  => $dataC,
            'valorCompra' => $ultimoIndiceC->SERIE->VALOR
            )
    );
})
->bind('cambio')
;
