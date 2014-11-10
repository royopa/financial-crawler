<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Finder\Finder;
use Goutte\Client;
<<<<<<< HEAD
use Entity\IGPM;
use Entity\SELIC;
use Entity\IPCA;
use Entity\CDI;
use Entity\Indicador;
use Malenki\Math\Stats;
=======
use Royopa\Financial\Indicador;
use Royopa\Financial\Cdi;
>>>>>>> 322338a5a4e31a4ab700dfb829370950557eb1d6

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
    //$url = 'ftp://ftp.ibge.gov.br/Precos_Indices_de_Precos_ao_Consumidor/IPCA/Serie_Historica/';
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

$app->get('/cdi_cetip', function () use ($app) {
    //$url = 'ftp://ftp.cetip.com.br/MediaCDI/';
    $url = __DIR__.'/../var/temp/MediaCDI/';
    $finder = new Finder();
    $finder->in($url);
    $finder->files();
    $finder->depth('== 0');
    $finder->files()->name('*.txt');
    $finder->size('< 1K');

    $entities = new \ArrayIterator();

    //pega a última data disponível no banco de dados
    $maiorData = new \DateTime($app['db']->fetchColumn('SELECT MAX(data) FROM cdi'));
   
    $stmt = $app['db']->prepare('INSERT INTO cdi (data, valor) VALUES (:data, :valor)');
   
    foreach ($finder as $file) {
        // ... do something
        $nomeData = str_replace('.txt', '', $file->getFilename());
        $data     = new \DateTime($nomeData);

        if ($data <= $maiorData) {
            continue;
        }
        
        $contents = (float) $file->getContents();
        $valor    = $contents / 100; //format the decimal
        $cdi      = new Cdi($data, $valor);

        //echo $file->getFilename() . ' - ' . $data->format('d/m/Y'). ' = ' . $valor . '<br/>';
        //se a data não existir na tabela, adiciona
        $stmt->bindValue('data', $data, "date");
        $stmt->bindValue('valor', $valor, "float");
        $stmt->execute();
    }

    $sql      = "SELECT data, valor FROM cdi ORDER BY data DESC LIMIT 10";
    $entities = $app['db']->fetchAll($sql);

    return $app['twig']->render(
        'cdi_cetip.html',
        array(
            'nome'     => 'Série Histórica CDI',
            'entities' => $entities
            )
    );
})
->bind('cdi_cetip')
;
