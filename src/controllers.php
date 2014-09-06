<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Goutte\Client;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {
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
    $url = 'http://www.cetip.com.br/';

    $client  = new Client();
    $crawler = $client->request('GET', $url);
    $client->getClient()->setDefaultOption('config/curl/'.CURLOPT_TIMEOUT, 60);

    $data  = $crawler->filter('#ctl00_Banner_lblTaxDateDI')->text();
    $data  = str_replace('(', '', $data);
    $data  = str_replace(')', '', $data);
    $valor = $crawler->filter('#ctl00_Banner_lblTaxDI')->text();

    //$html = $crawler->html();
    //return new Response($html);

    return $app['twig']->render(
        'cdi.html',
        array(
            'data'  => $data,
            'valor' => $valor
            )
    );
})
->bind('cdi')
;

$app->get('/selic', function () use ($app) {

    $url     = 'http://www3.bcb.gov.br/selic/consulta/taxaSelic.do?method=listarTaxaDiaria&idioma=P';

    $client  = new Client();
    $crawler = $client->request('GET', $url);
    $client->getClient()->setDefaultOption('config/curl/'.CURLOPT_TIMEOUT, 60);

    $form = $crawler->selectButton('Consultar')->form();

    //$html = $crawler->html();
    //return new Response($html);

    $crawler = $client->submit(
        $form,
        array(
            'dataInicial'      => '01/09/2011',
            'dataFinal'        => '05/09/2014',
            'tipoApresentacao' => 'tela'
            )
    );

    $html = $crawler->html();

    //return new Response($html);

    return $app['twig']->render('selic.html', array());
    //https://github.com/guzzle/guzzle-silex-extension
    //http://guzzle3.readthedocs.org/en/latest/webservice-client/using-the-service-builder.html
    //http://catalogo.governoeletronico.gov.br/arquivos/Documentos/WS_SGS_BCB.pdf
    //https://www3.bcb.gov.br/sgspub/JSP/sgsgeral/FachadaWSSGS.wsdl
    //https://www3.bcb.gov.br/wssgs/services/FachadaWSSGS
})
->bind('selic')
;

$app->get('/ipca', function () use ($app) {
    return $app['twig']->render('ipca.html', array());
})
->bind('ipca')
;

$app->get('/igpm', function () use ($app) {
    return $app['twig']->render('igpm.html', array());
})
->bind('igpm')
;
