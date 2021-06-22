Financial Crawler
=================

Um crawler para indicadores financeiros escrito em PHP usando o Silex Framework

https://dados-financeiros.herokuapp.com/

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

Rodando na sua máquina local
----------------------------
```sh
composer run
```
http://localhost:8080


Deploy Simples
--------------
```sh
composer deploy
```

Deploy Sync Remote
------------------
```sh
composer deploy-sync-remote
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

