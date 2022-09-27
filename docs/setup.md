# Zprovoznění vývojového prostředí


### 1. Příprava vývojového prostředí
- instalace _Git_
- instalace  _Visual Studio Code_
  - budu potřebovat rozšíření `PHP Intelephense`, `PHP Debug` a `Gitlens`
- stažení repozitáře se zdrojovým kódem
  - Otevřu VS Code a kliknu na `Open repository` a vyberu si `https://github.com/luksladky/KIIS`. To mi otevře výběr umístění složky, kam se má repo stáhnout.

### 2. Instalace EasyPhp Devserver 
https://www.easyphp.org/

Po spuštění bude v ikonkami aplikací na pozadí (vedle hodin) EasyPhp. Pravým tlačítkem vyvoláš nabídku a klineš na _Open Dashboard_.

Pozn.: Pokud se nic nestane, je nejspíš obsazený port. Pak je třeba otevřít `c:\Program Files (x86)\EasyPHP-Devserver-17\run-devserver.ini` a přepsat všude `127.0.0.1:1111` na např. `127.0.0.1:2222`.

### 3. Stáhnutí potřebných komponent
1. Apache 2.4.48 (x64) - https://warehouse.easyphp.org/inventory-devserver#apache
2. PHP 7.1 (x64)
3. PhpMyAdmin 
4. Virtual hosts manager - https://warehouse.easyphp.org/inventory-devserver#devtools
5. Xdebug Manager - https://warehouse.easyphp.org/inventory-devserver#devtools¨

Vše je třeba nainstalovat.

### 4. Připravit mapování na adresář
EasyPhp dashboard má modul Virtual Hosts Manager 2.0. Připravíme si mapování na adresář:
- Je nutné zajistit Write access na soubor `c:\Windows\System32\drivers\etc\hosts` pro _User_
    - Pravým tlačítkem na soubor `hosts` > Security > Users > Zaškrtnout Modify a Write
- `add virtual host`
  - Choose a name: _kiis_
  - Copy below the path to your directory: cesta ke zkopírovanému repozitáři
- Poté můžu kliknout na tlačítko `http` vedle _kiis_ nebo napsat do prohlížeče na zkoušku `http://kiis/servertest.txt`.


### 5. Konfigurace PHP

Je třeba upravit `php.ini`: 

- EasyPhp dashboard > HTTP Server > `ozubené kolečko` > Vlevo `PHP Configuration` > `Configuration file` > tužtička`
    - pozor, v levém panelu je třeba vybrat verzi Apache 2.4.48.  
- přepsat `upload_max_filesize = 2M` na `upload_max_filesize = 50M`
- přepsat hodnotu `xdebug.remote_autostart` na `xdebug.remote_autostart = 1`
- `xdebug.remote_port=9000`
- `xdebug.default_enable=1`
- `xdebug.auto_trace=1`
- (re)startovat HTTP server




### 6. Nahrát data do databáze
Otevřu si modul EasyPhp > `MySQL Administration : PhpMyAdmin 4.7.0`. 
- Vlevo nahoře kliknu na `New` a vytvořím novou databázi `ddmhradek_cz`.
- Otevřu ji, vyberu v horní liště `Import`. Nahraju soubor z repozitáře `backup/ddmhradek_cz.sql`
- Nyní by mělo fungovat otevření `http://kiis`, stejně jako online verze.


### 7. Zapnout Debug
- Ujistím se, že mám zapnutý server i databázi
- Zapnout v EasyPHP Dashboard XDebug Manager a v něm Trace
- Ve Visual Studiu záložka Run and Debug > Kliknout na tlačítko Run vedle `Listen for XDebug`
- Nyní by mělo být možné přidat někam breakpoint (klinu vlevo od čísla řádku). Po načtení stránky v prohlížeči by se mi měla zaseknout na správném místě.


### (Volitelné)

- Přidat php.exe do `PATH` pro použití z příkazové řádky a pro aktualizaci závislostí s `composer update`.
    - (Settings > About > Advanced system settings > Environment variables > User variables > select `Path` > Edit > přidat cestu do adresáře s PHP)




