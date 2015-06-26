Financial Crawler
=================

Um crawler para indicadores financeiros escrito em PHP usando o Silex Framework

http://financial-crawler.url.ph/

Os dados disponíveis estão vindo das seguintes fontes:
 - BACEN, através do SGS - Sistema Gerenciador de Séries Temporais - https://www3.bcb.gov.br/sgspub/;
 - Quandl - https://www.quandl.com/
 - ANBIMA - http://www.anbima.com.br/
 - CETIP - http://www.cetip.com.br/

Os dados disponíveis até o momento são
 - CDI
 - SELIC
 - IGPM
 - Câmbio
 - Bovespa

##Rodando a aplicação

Run on vagrant
```sh
vagrant up
```
http://192.168.33.100/web/index_dev.php


Rodando na sua máquina local
----------------------------
```sh
composer run
```
http://localhost:8080


Fazendo de deploy da aplicação
----------------------------
```sh
composer deploy
```

##TO DO

Índices IMA - última posição
----------------------------

(IMA-Geral, IRF-M, IMA-C, IMA-B, IMA-S)
----------------------------

Formulário
----------
http://www.anbima.com.br/ima/ima-geral.asp

Última Posição
--------------
http://www.anbima.com.br/ima/arqs/ima_completo.xml

IDkA Anbima
-----------
http://www.anbima.com.br/idka/IDkA.asp

