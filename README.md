# SuluAssociationContactBundle

<a href="https://github.com/manuxi/SuluAssociationContactBundle/blob/main/LICENSE" target="_blank">
<img src="https://img.shields.io/github/license/manuxi/SuluAssociationContactBundle" alt="GitHub license">
</a>
<a href="https://github.com/manuxi/SuluAssociationContactBundle/tags" target="_blank">
<img src="https://img.shields.io/github/v/tag/manuxi/SuluAssociationContactBundle" alt="GitHub tag">
</a>

A Sulu CMS bundle for managing association and membership properties on contacts.
It adds an extra tab to the contact edit form in the Sulu admin with fields like member status, membership dates, display preferences and more.

![Form](docs/img/contact_form.de.png)

**Deutsch?** Siehe [README.de.md](README.de.md)

## Requirements

- PHP >= 8.2
- Sulu >= 3.0
- Symfony >= 7.0

## Installation

Install the package with:
```console
composer require manuxi/sulu-association-contact-bundle
```

If you're *not* using Symfony Flex, add the bundle in your `config/bundles.php` file:

```php
return [
    //...
    Manuxi\SuluAssociationContactBundle\SuluAssociationContactBundle::class => ['all' => true],
];
```

Add the following to your `config/routes/sulu_association_contact_admin.yaml`:
```yaml
SuluAssociationContactBundle:
    resource: '@SuluAssociationContactBundle/Resources/config/routes_admin.yaml'
```

Update the database schema:

```bash
# Preview the SQL statements
php bin/console doctrine:schema:update --dump-sql

# Apply the changes
php bin/console doctrine:schema:update --force
```

Make sure you only process this bundle's schema updates!

## Configuration

There is no configuration required. The bundle registers all necessary services, forms and routes automatically.
