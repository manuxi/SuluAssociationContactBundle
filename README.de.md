# SuluAssociationContactBundle!
![php workflow](https://github.com/manuxi/SuluAssociationContactBundle/actions/workflows/php.yml/badge.svg)
![symfony workflow](https://github.com/manuxi/SuluAssociationContactBundle/actions/workflows/symfony.yml/badge.svg)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://github.com/manuxi/SuluAssociationContactBundle/blob/main/LICENSE)
![GitHub Tag](https://img.shields.io/github/v/tag/manuxi/SuluAssociationContactBundle)
![Supports Sulu 3.0 or later](https://img.shields.io/badge/%20Sulu->=3.0-0088cc?color=00b2df)

[🇬🇧 English Version](README.md)

Das SuluAssociationContactBundle erweitert Sulu CMS um eine Vereins- und Mitgliedschaftsverwaltung für Kontakte.

Es fügt im Sulu-Admin einen zusätzlichen Tab zum Kontakt-Bearbeitungsformular hinzu, mit Feldern wie Mitgliedsstatus, Mitgliedschaftsdaten, Anzeige-Einstellungen und mehr.

![Form](docs/img/contact_form.de.png)

## Features

### Mitgliedschaftsverwaltung
- **Mitgliedsstatus** - 11 konfigurierbare Status: aktiv, passiv, Ehren-, Förder-, Gründungs-, Jugend-, Vorstands-, Probe-, auswärtig, ruhend, Gast
- **Anzeige-Steuerung** - Konfigurierbar ob und wie Mitglieder auf der Webseite erscheinen (keine Anzeige, nur Vorname, voller Name)
- **Daten** - Mitglied-seit-Datum, Ruht-seit-Datum
- **Notizen** - Anmerkungen zur Mitgliedschaft

### Weitere Daten
- **Namenszusätze** - Prefix und Suffix für Mitgliedsnamen
- **Anmerkungen & Motivation** - Rich-Text-Felder für persönliche Notizen
- **Verstorben-Markierung** - Verstorbene Mitglieder mit Datum erfassen

### Einstellungen
- **Toggle-Steuerung** - Header, Hero und Breadcrumb Anzeige-Toggles
- **Seitenverweise** - Konfigurierbare Übersichtsseiten pro Mitgliedsstatus für Breadcrumbs

### Integration
- **Sulu Admin Tab** - Nahtlose Integration in das Bearbeitungsformular der Kontakte
- **Admin-Listenspalten** - Mitgliedsstatus, Daten und Anzeigetyp in der Kontaktliste such- und filterbar
- **Aktivitätsprotokoll** - Änderungen an Kontaktdaten werden über Sulus Aktivitätssystem erfasst
- **Twig-Extensions** - Zugriff auf Mitgliedsstatus und Einstellungen in Templates

## Voraussetzungen

- PHP 8.2 oder höher
- Sulu CMS 3.0 oder höher
- Symfony 7.0 oder höher

## Installation

### Schritt 1: Paket installieren

```bash
composer require manuxi/sulu-association-contact-bundle
```

Falls *nicht* Symfony Flex verwendet wird, das Bundle in `config/bundles.php` hinzufügen:

```php
return [
    //...
    Manuxi\SuluAssociationContactBundle\SuluAssociationContactBundle::class => ['all' => true],
];
```

### Schritt 2: Routen konfigurieren

Zu `config/routes/sulu_association_contact_admin.yaml` hinzufügen:

```yaml
SuluAssociationContactBundle:
    resource: '@SuluAssociationContactBundle/Resources/config/routes_admin.yaml'
```

### Schritt 3: Datenbank aktualisieren

```bash
# Prüfen, was erstellt wird
php bin/console doctrine:schema:update --dump-sql

# Migration ausführen
php bin/console doctrine:schema:update --force
```

Dabei sicherstellen, dass die Schema-Änderungen dieses Bundles verarbeitet werden!

### Schritt 4: Berechtigungen erteilen

1. Navigation zu Sulu Admin > Einstellungen > Benutzerrollen
2. Passende Rolle finden
3. Berechtigungen für "Contact/Settings" aktivieren
4. Seite neuladen

## Dokumentation

- [Einstellungen](docs/settings.de.md) - Konfigurationsoptionen
- [Website-Controller](docs/website-controller.de.md) - Beispiel-Controller und Templates für das Frontend

## Konfiguration

Es ist keine weitere Konfiguration erforderlich. Das Bundle registriert die notwendigen Services und Formulare selbst.

## Mitwirken

Beiträge sind willkommen! Bitte erstelle Issues oder Pull Requests.

## Lizenz

Dieses Bundle ist unter der MIT-Lizenz lizenziert. Siehe [LICENSE](LICENSE).

## Credits

Erstellt und gewartet von [manuxi](https://github.com/manuxi).

Danke an das Sulu-Team für das tolle CMS und den fantastischen Support!
