<?php

/**
 * Faz consulta ao webservice do banco central para recuperação do IGP-M
 * @author Julio Cezar - <julio@soltein.com.br>
 */

namespace Royopa\Financial\Tests;

use Silex\WebTestCase;

class Test extends WebTestCase
{
    public function testInitialPage()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('h1:contains("financial-crawler")'));
        $this->assertCount(1, $crawler->filter('p:contains("Utilize o menu para consultar os indicadores desejados.")'));

        $crawler = $client->request('GET', '/cdi');
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('h1:contains("CDI")'));
        $this->assertCount(1, $crawler->filter('p:contains(" : ")'));
        $this->assertCount(1, $crawler->filter('p:contains(" %")'));

        $crawler = $client->request('GET', '/selic');
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('h1:contains("SELIC")'));
        $this->assertCount(1, $crawler->filter('p:contains(" : ")'));
        $this->assertCount(1, $crawler->filter('p:contains(" %")'));

        $crawler = $client->request('GET', '/ipca');
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('h1:contains("IPCA")'));
        $this->assertCount(1, $crawler->filter('p:contains(" : ")'));
        $this->assertCount(1, $crawler->filter('p:contains(" %")'));

        $crawler = $client->request('GET', '/igpm');
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('h1:contains("IGPM")'));
        $this->assertCount(1, $crawler->filter('p:contains(" : ")'));
        $this->assertCount(1, $crawler->filter('p:contains(" %")'));

        $crawler = $client->request('GET', '/bovespa');
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('h1:contains("BOVESPA")'));
        $this->assertCount(1, $crawler->filter('p:contains(" : ")'));
        $this->assertCount(1, $crawler->filter('p:contains(" pontos")'));

        $crawler = $client->request('GET', '/cambio');
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('h1:contains("Dólar americano")'));
        $this->assertCount(1, $crawler->filter('h2:contains("Venda")'));
        $this->assertCount(1, $crawler->filter('h2:contains("Compra")'));
        $this->assertCount(2, $crawler->filter('p:contains("R$ ")'));
    }

    public function createApplication()
    {
        $app = require __DIR__.'/../../../../web/app_test.php';
        $app['debug'] = true;
        $app['exception_handler']->disable();

        return $app;
    }
}
