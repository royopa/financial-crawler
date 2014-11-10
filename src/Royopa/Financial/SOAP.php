<?php
/**
*@author Julio Cezar - <julio@soltein.com.br>
*@description Faz consulta o webservice do banco central e retorna o IGP-M atual
*/

namespace Royopa\Financial;

class SOAP extends \SOAPClient
{
    private static $instance;

    private function SOAP($url)
    {
        return parent::__construct($url);
    }

    public static function getInstance($dados)
    {
        if (empty(self::$instance)) {
            self::$instance = new SOAP($dados);
        }

        return self::$instance;
    }

    public function call($configuracoes)
    {
        return parent::__soapCall($configuracoes[0], $configuracoes[1]);
    }
}
