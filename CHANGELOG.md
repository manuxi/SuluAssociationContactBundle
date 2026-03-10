# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2026-03-10

### Changed
- Upgraded to Sulu 3.0 and Symfony 7.0
- Replaced `services.xml` with `services.yaml`
- Replaced `@RouteResource` annotations with `#[Route]` PHP attributes on controllers
- Replaced `ClassResourceInterface` / REST-routing with attribute-based routing (`type: attribute`)
- Replaced `handleView()` / `view()` responses with `JsonResponse`
- Moved forms and lists from `config/` to `src/Resources/config/`
- Moved translations from `translations/` to `src/Resources/translations/`
- Replaced service IDs with FQCN in `services.yaml`
- Updated form XML service references to use FQCN
- Settings admin is now standalone (no longer depends on SuluAppSettingsBasicBundle)
- Settings admin registers its own navigation item in Sulu's settings area
- Security context changed from `sulu.settings.app_settings_members` to `sulu.settings.association_contact`
- Controller methods use `array_key_exists` checks for partial updates
- DI Extension uses `YamlFileLoader` instead of `XmlFileLoader`
- Updated route names: `sulu_association_contact.get`, `sulu_association_contact.put`, `sulu_association_contact.get_settings`, `sulu_association_contact.put_settings`

### Added
- Type declarations on all method signatures
- Readonly constructor promotion where applicable
- Fluent setter return types on entity methods
- German README (`README.de.md`)
- Security contexts registration via `getSecurityContexts()`

### Removed
- Dependency on `manuxi/sulu-app-settings-basic-bundle`
- Dependency on `phpcr/phpcr-migrations-bundle`
- `routes_admin.yml` (replaced by `routes_admin.yaml`)
- Old `config/services.xml`
- Old `config/packages/association_contact_settings_admin.yaml` (now in DI Extension)
