# Zprovoznění vývojového prostředí


### 1. Příprava vývojového prostředí
- instalace _Git_
- instalace  _Visual Studio Code_
  - budu potřebovat rozšíření `PHP Intelephense` a `PHP Debug`
- stažení repozitáře se zdrojovým kódem
  - Otevřu VS Code a kliknu na `Open repository` nebo stáhnu ZIP z `https://github.com/luksladky/KIIS`

### 2. Instalace EasyPhp Devserver 
https://www.easyphp.org/

Po spuštění bude v ikonkami aplikací na pozadí (vedle hodin) EasyPhp. Pravým tlačítkem vyvoláš nabídku a klineš na _Open Dashboard_.

Pozn.: Pokud se nic nestane, je nejspíš obsazený port. Pak je třeba otevřít `c:\Program Files (x86)\EasyPHP-Devserver-17\run-devserver.ini` a přepsat všude `127.0.0.1:1111` na např. `127.0.0.1:2222`.

### 3. Stáhnutí potřebných komponent
1. Apache 2.4.48 (x64) - https://warehouse.easyphp.org/inventory-devserver#apache
2. PHP 7.1 (x64)
3. PhpMyAdmin 
4. Virtual hosts manager - https://warehouse.easyphp.org/inventory-devserver#devtools
5. Xdebug Manager - https://warehouse.easyphp.org/inventory-devserver#devtools

### 4. Konfigurace PHP

Je třeba upravit `php.ini`: 

- EasyPhp dashboard > HTTP Server > `ozubené kolečko` > `PHP Configuration` > `Configuration file` > tužtička`
- přepsat `upload_max_filesize = 2M` na `upload_max_filesize = 50M`
- přepsat hodnotu `xdebug.remote_autostart` na `xdebug.remote_autostart = 1`
- restartovat HTTP server

(Volitelné) Přidat php.exe do `PATH` pro použití z příkazové řádky a pro aktualizaci závislostí s `composer update`.
- (Settings > About > Advanced system settings > Environment variables > User variables > select `Path` > Edit > přidat cestu do adresáře s PHP)

### 5. Připravit mapování na adresář
EasyPhp dashboard má modul Virtual Hosts Manager 2.0. Připravíme si mapování na adresář:
- (Možná bude třeba) Write access na soubor `c:\Windows\System32\drivers\etc\hosts` pro _User_
- `add virtual host`
  - Choose a name: _kiis_
  - Copy below the path to your directory: cesta ke zkopírovanému repozitáři
- Poté můžu kliknout na tlačítko `http` vedle _kiis_ nebo napsat do prohlížeče na zkoušku `http://kiis/servertest.txt`.

### 6. Nahrát data do databáze
Otevřu si modul EasyPhp > `MySQL Administration : PhpMyAdmin 4.7.0`. 
- Vlevo nahoře kliknu na `New` a vytvořím novou databázi `ddmhradek_cz`. 
- Otevřu ji, vyberu v horní liště `Import`. Nahraju soubor z repozitáře `backup/ddmhradek_cz.sql`
- Nyní by mělo fungovat otevření `http://kiis`, stejně jako online verze.








