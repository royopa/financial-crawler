<?php

/**
 * Faz consulta ao ftp da CETIP para recuperação da taxa CDI Over
 * @author royopa - <royopao@gmail.com>
 */

namespace Royopa\Financial;

class Cdi
{
    private $data;

    private $valor;

    public function __construct(\DateTime $data, $valor)
    {
        $this->data  = $data;
        $this->valor = (float) $valor;
    }

    /**
     * Gets the value of data.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Sets the value of data.
     *
     * @param mixed $data the data
     *
     * @return self
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Gets the value of valor.
     *
     * @return mixed
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Sets the value of valor.
     *
     * @param mixed $valor the valor
     *
     * @return self
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }
}
