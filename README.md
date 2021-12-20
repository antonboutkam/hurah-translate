# Hurah Translation functionality
This library / package comes with the Hurah system and has no practical 
use cases on it's own. 

# How it is supposed to work.
Below are directory structure patterns that exist in the system and 
contain strings that need to be translated. A user interface in the 
admin section of the admin panel is available to edit the translations.

```
/admin_modules/<module-name>/<sub-module-name>
/admin_modules/<module-name>/<sub-module-name>/<sub-module-name>
/public_html/<website-name>/modules/<module-name>
/public_html/<website-name>/modules/<module-name>/<sub-module-name>
/public_html/<website-name>/modules/<module-name>/<sub-module-name>/<sub-module-name>
/public_html/<website-name>/<some-directory>/modules/<module-name>
/classes/Crud/<some-directory>/Field
/classes/Crud/Custom/<system-name>/<some-directory>/Field
```

To prevent having hundreds of translation files (multiplied by x languages)
the translation files should be grouped to the first variable level in the 
patterns described above.

```
<locale-dir>/admin_modules/<module-name>/Locales/<locale-name>.json
<locale-dir>/public_html/<website-name>/modules/<module-name>/<locale-name>.json
what to do here ? >>>> <locale-dir>/public_html/<website-name>/<some-directory>/modules/<module-name>
<locale-dir>/classes/Crud/<some-directory>/Field/Locales/<locale-name>.json
<locale-dir>/classes/Crud/Custom/<system-name>/<some-directory>/Field/Locales/<locale-name>.json
```

#Translate something
```php
<?php
$systemRoot = "/home/anton/Documents/sites/hurah/(admin_modules|modules|classes/Crud)";
$translationRoot = "/home/anton/Documents/sites/hurah/data";

$aTemplates = [

    /* admin_modules/ */
    "Custom/Cockpit/Foodbox/Finder/top_nav_search.twig",
    
    /* public_html/_default/modules */
    /* public_html/vangoolstoffenonline.nl/modules */
    /*  (merge) */
    "ProductList/Components/Product/{$sTemplateDir}/collection.twig",
    
    /* public_html/antonboutkam.nl/modules */
    "System/Modules/Projects/Project/page.twig",
    
    /* public_html/antonboutkam.nl/System/Modules */
    "System/Modules/Contact/contact.twig",
    
    /* classes */
    "Crud/Bank/Field" 
]


$language = new Language($systemRoot, $translationRoot);
$language->translate($templateName, $stringToTranslate);

```
