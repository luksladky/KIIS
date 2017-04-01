# Doplňky

## Upload control
Automatické nahrávání a odstraňování obrázků včetně náhledu.

**Instalace:**
Rozšíření automaticky registruje doplňky k formulářům (lze zakázat v configu).

**Použítí:**

```php

protected function createComponentForm() {
    $form = new Nette\Application\UI\Form;

    $row = $this->getFromDatabase();

    $form->addImageUpload('upload', 'Upload')
            ->setDefaultValue($row->upload) // Obsahuje např. namespace/upload.png
            ->setRequired()
            ->addRule($form::MAX_FILE_SIZE, NULL, 1024)
            ->setNamespace('namespace');

    $form->onSuccess[] = $this->successForm;

    return $form;
}

public function successForm($form, $values) {
    $row = $this->getFromDatabase();
    
    $row->upload = $values->upload; // Obsahuje namespace/unikatniNazevObrazku.png nebo NULL, když není vyplněno pole nebo zaškrtnuto odstranění.

    $row->update();
}

```

## Funkce

```php

$upload->getCheckbox()->setHeight(150); // Pevná výška náhledu
$upload->getCheckbox()->setWidth(150); // Pevná šířka náhledu

```

## MultiUpload
Vytvoří náhledy nahraných obrázku včetně checkboxu

```php
protected function createComponentForm() {
    $form = new Nette\Application\UI\Form;

    $row = $this->getFromDatabase();

    $form->addMultiImageUpload('upload', 'Upload', 'namespace')
        ->setDefaultValue([
            'namespace/firstImage.png',
            'namespace/secondImage.png'
        ]);

    $form->onSuccess[] = $this->successForm;

    return $form;
}

public function successForm($form, $values) {
    $row = $this->getFromDatabase();

    $row->upload = $values->upload; // Contains array

    $row->update();
}

```
