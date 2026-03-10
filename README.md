# SuluAssociationContactBundle!
![php workflow](https://github.com/manuxi/SuluAssociationContactBundle/actions/workflows/php.yml/badge.svg)
![symfony workflow](https://github.com/manuxi/SuluAssociationContactBundle/actions/workflows/symfony.yml/badge.svg)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://github.com/manuxi/SuluAssociationContactBundle/blob/main/LICENSE)
![GitHub Tag](https://img.shields.io/github/v/tag/manuxi/SuluAssociationContactBundle)
![Supports Sulu 3.0 or later](https://img.shields.io/badge/%20Sulu->=3.0-0088cc?color=00b2df)

[🇩🇪 Deutsche Version](README.de.md)

The SuluAssociationContactBundle extends Sulu CMS with association and membership management for contacts.

It adds an extra tab to the contact edit form in the Sulu admin with fields like member status, membership dates, display preferences and more.

![Form](docs/img/contact_form.de.png)

## Features

### Membership Management
- **Member Status** - 11 configurable statuses: active, passive, honorary, supporting, founding, youth, board, probationary, external, dormant, guest
- **Display Control** - Configure if and how members appear on the website (no display, first name only, full name)
- **Dates** - Member-since date, suspended-since date
- **Notes** - Rich text notes on membership

### Additional Data
- **Name Additions** - Prefix and suffix for member names
- **Annotations & Motivation** - Rich text fields for personal notes
- **Deceased Tracking** - Mark deceased members with date

### Settings
- **Toggle Controls** - Header, hero and breadcrumb display toggles
- **Page References** - Configurable overview pages per member status for breadcrumbs

### Integration
- **Sulu Admin Tab** - Seamless integration into the contact edit form
- **Admin List Columns** - Member status, dates and display type searchable and filterable in the contact list
- **Activity Logging** - Contact data changes tracked via Sulu's activity system
- **Twig Extensions** - Access member status and settings in templates

## Prerequisites

- PHP 8.2 or higher
- Sulu CMS 3.0 or higher
- Symfony 7.0 or higher

## Installation

### Step 1: Install the package

```bash
composer require manuxi/sulu-association-contact-bundle
```

If you are *not* using Symfony Flex, add the bundle to `config/bundles.php`:

```php
return [
    //...
    Manuxi\SuluAssociationContactBundle\SuluAssociationContactBundle::class => ['all' => true],
];
```

### Step 2: Configure routes

Add to `config/routes/sulu_association_contact_admin.yaml`:

```yaml
SuluAssociationContactBundle:
    resource: '@SuluAssociationContactBundle/Resources/config/routes_admin.yaml'
```

### Step 3: Update the database

```bash
# Check what will be created
php bin/console doctrine:schema:update --dump-sql

# Execute migration
php bin/console doctrine:schema:update --force
```

Make sure you only process this bundle's schema updates!

### Step 4: Grant permissions

1. Go to Sulu Admin > Settings > User Roles
2. Find the appropriate role
3. Enable permissions for "Contacts / settings"
4. Reload the page

## Documentation

- [Settings](docs/settings.en.md) - Configuration options
- [Website Controller](docs/website-controller.en.md) - Example controller and templates for the frontend

## Configuration

No additional configuration required. The bundle registers all necessary services, forms and routes automatically.

## Contributing

Contributions are welcome! Please create issues or pull requests.

## License

This bundle is licensed under the MIT License. See [LICENSE](LICENSE).

## Credits

Created and maintained by [manuxi](https://github.com/manuxi).

Thanks to the Sulu team for the great CMS and fantastic support!
