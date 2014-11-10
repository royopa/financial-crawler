<?php

/**
 * Faz consulta ao webservice do banco central para recuperação do IGP-M
 * @author Julio Cezar - <julio@soltein.com.br>
 */

namespace Royopa\Financial;

use Royopa\Financial\SOAP;

class Indicador
{
    private $url;
    private $codigoSerie;

    public function __construct($codigoSerie = 0)
    {
        $this->url         = "https://www3.bcb.gov.br/sgspub/JSP/sgsgeral/FachadaWSSGS.wsdl";
        $this->codigoSerie = $codigoSerie;
    }

    /**
     *Função para acessar soap
     * @access public
     * @param array contendo os itens necessários para o retorno do webservice
     * @return objeto XML
     */
    public function soap($conf)
    {
        $proxy = array(
            'proxy_host'     => "10.192.38.86",
            'proxy_port'     => 80,
            'proxy_login'    => "c090762@CORPCAIXA",
            'proxy_password' => "Ro3648");

        $cliente = SOAP::getInstance($this->url, $proxy);

        $resultado = $cliente->call($conf);
        return simplexml_load_string($resultado);
    }

    /**
     *Soma o indice dos ultimos 12 meses
     * @access public
     * @param type XML retornado da função soap
     * @return A soma dos indices
     */
    public function somaUltimos12Meses($xml)
    {
        $soma = 1;
        foreach ($xml->SERIE->ITEM as $item) {
            $soma = (float) $soma * ( (float) ((float)$item->VALOR/100) + 1 );
        }

        return ($soma-1)*100;
    }

    /**
     *
     * @param type XML retornado da função soap
     * @return O ultimo indíce convertido em float.
     */
    public function converterIndiceFloat($xml)
    {
        /**
         * O valor será retornado como X.XXX,XX se usar o number_format, ou mesmo converter direto para float
         * o mesmo será truncado para baixo. Neste caso substituir o . da milhar por vazio e a , por ponto de modo a converter considerando
         * as casas decimais.
         */
        return ((float) str_replace(",", ".", str_replace(".", "", (string) $xml->SERIE->VALOR)));
    }

    /**
     *
     * @return type XML contendo o ultimo indice do IGP-M
     */
    public function getUltimoIndiceXML()
    {
        $conf[0] = 'getUltimoValorXML';
        $conf[1] = array('codigoSerie' => $this->codigoSerie);

        return $this->soap($conf);
    }

    /**
     *
     * @return type Os indices dos ultimos 12 meses em formato XML
     */
    public function getUltimos12Meses()
    {
        $mes = date('m');
        $ano = date('Y');

        $dataInicio = date("d/m/Y", strtotime("-12 month", mktime(0, 0, 0, $mes, 01, $ano)));
        $dataFim = date("d/m/Y", mktime(0, 0, 0, $mes + 1, 0, $ano));

        $conf[0] = 'getValoresSeriesXML';
        $conf[1] = array('codigoSeries' => array($this->codigoSerie), 'dataInicio' => $dataInicio, 'dataFim' => $dataFim);

        return $this->soap($conf);
    }
}
