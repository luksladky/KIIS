# Použitý framework a zdroje
Projekt stojí na Nette frameworku 2.3. Velmi čtivá dokumentace v češtině je zde: https://doc.nette.org/cs/2.3/

Šablony používají Latte (původně součást Nette). Dokumentace je k nalezení na https://latte.nette.org/cs/guide. Doporučuji si zkusit pohrát s online sandboxem - https://fiddle.nette.org/latte/. Vpravo nahoře se dá navolit složitější example.

# Struktura

Nette používá MVP pattern, tedy Model–view–presenter. Veškerá backendová logika je ve složce `app`.

### Model
Model se stará o tahání z databáze. Jednotlivé `Repository` reprezentují jednotlivé tabulky, `Facade` se pak stará o agregaci dat z více `Repository`.

### Presenter
Presenter definuje jednotlivé endpointy. Pokud třída dědí od `BaseSecurePresenter` a obsahuje funkci `render<název stránky>` nebo `action<název akce>`, tak je automaticky zaregistrovaná routerem. To znamená, že adresa `kiis/?parameter=123?&action=show&presenter=Event` bude volat funkci `actionShow($parameter)` v `EventPresenter`u.

### View (Templates)
Aby se na stránce něco zobrazilo, je potřeba ještě vytvořit příslušnout šablonu `<název akce>.latte` ve složce `app/templates/<název presenteru>`. Šablony jsou v jazyku Latte, což je v podstatě HTML, kde můžu používat PHP logiku pomocí složených závorek. Například `{var $index}` definuje proměnnou `$index` a `{if $index > 0}...{/if}` vykreslí HTML uvnitř pouze, pokud je splněná podmínka.

# Vytváření formulářů

Standard je vytvořit Factory třídu v `app/forms` a tu následné použít v presenteru ve funkci s názvem `createComponent<název komponenty>`. Tu pak můžu používat v Latte pomocí `{control <název komponenty>}`.

Pozn.: Formuláři se musí přidat callback ` $form->onSuccess[] = array($this, '<název funkce spuštěné při odeslání>');`
# Úprava CSS stylů

Vizuální styl je definovaný v SCSS souborech ve složce `www/css` a podsložkách. Ke kompilaci je potřeba doplněk `Live Sass Compiler`.

# Javascript

Interaktivita na straně prohlížeče se upravuje v `www/js/main.js`. Ve složce `vendor` jsou knihovny, které používáme.

# Užitečné tipy
- krom debuggeru se hodí i funkce `dump($jmenopromenne);`.