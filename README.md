# SuluAssociationContactBundle!
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://github.com/manuxi/SuluAssociationContactBundle/LICENSE)
![GitHub Tag](https://img.shields.io/github/v/tag/manuxi/SuluAssociationContactBundle)

I made this bundle to have the possibility to manage association properties in the Sulu contacts.

![image](https://github.com/user-attachments/assets/44d7467d-316c-4433-a3e3-2eff0541bcad)

## 👩🏻‍🏭 Installation
Install the package with:
```console
composer require manuxi/sulu-association-contact-bundle
```
If you're *not* using Symfony Flex, you'll also
need to add the bundle in your `config/bundles.php` file:

```php
return [
    //...
    Manuxi\SuluAssociationContactBundle\SuluAssociationContactBundle::class => ['all' => true],
];
```
Please add the following to your `routes_admin.yaml`:
```yaml
SuluAssociationContactBundle:
    resource: '@SuluAssociationContactBundle/Resources/config/routes_admin.yml'
```
Last but not least the schema of the database needs to be updated.  

Some properties in co_contacts will be created.  

See the needed queries with
```
php bin/console doctrine:schema:update --dump-sql
```  
Update the schema by executing 
```
php bin/console doctrine:schema:update --force
```  

Make sure you only process the bundles schema updates!

## 🧶 Configuration
There exists no configuration yet.

