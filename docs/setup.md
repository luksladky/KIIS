# Zprovoznění vývojového prostředí
### 1. stáhnout EasyPhp Devserver 
https://www.easyphp.org/

Po spuštění bude v ikonkami aplikací na pozadí (vedle hodin) EasyPhp. Pravým tlačítkem vyvoláš nabídku a klineš na _Open Dashboard_.

Pozn.: Pokud se nic nestane, je nejspíš obsazený port. Pak je třeba otevřít `c:\Program Files (x86)\EasyPHP-Devserver-17\run-devserver.ini` a přepsat všude `127.0.0.1:1111` na např. `127.0.0.1:2222`.

### . Stáhnutí potřebných komponent
1. Apache 2.4.48 (x64) - https://warehouse.easyphp.org/inventory-devserver#apache
2. PHP 7.1 (x64)
3. PhpMyAdmin 
4. Virtual hosts manager - https://warehouse.easyphp.org/inventory-devserver#devtools
5. Xdebug Manager - https://warehouse.easyphp.org/inventory-devserver#devtools



- Přidat php.exe do `PATH` (Settings > About > Advanced system settings > Environment variables > User variables > select `Path` > Edit > přidat cestu do adresáře s PHP)
- Upravit php.ini
  - přepsat `upload_max_filesize = 2M` na `upload_max_filesize = 50M`
  - restartovat server

### Připravit mapování na adresář
- Write access na soubor `c:\Windows\System32\drivers\etc\hosts` pro _User_ 








