# SuluAssociationContactBundle!
<a href="https://github.com/manuxi/SuluAssociationContactBundle/blob/main/LICENSE" target="_blank">
<img src="https://img.shields.io/github/license/manuxi/SuluAssociationContactBundle" alt="GitHub license">
</a>
<a href="https://github.com/manuxi/SuluAssociationContactBundle/tags" target="_blank">
<img src="https://img.shields.io/github/v/tag/manuxi/SuluAssociationContactBundle" alt="GitHub license">
</a>

I made this bundle to have the possibility to manage association properties in the Sulu contacts.

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

