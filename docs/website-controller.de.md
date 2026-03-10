# Website-Controller

Dieses Bundle stellt keinen eigenen Website-Controller bereit. Die Darstellung der Mitglieder auf der Website wird in der jeweiligen Sulu-Applikation implementiert.

## Beispiel-Controller

```php
<?php

namespace App\Controller\Website;

use Sulu\Bundle\ContactBundle\Entity\ContactRepositoryInterface;
use Sulu\Bundle\WebsiteBundle\Resolver\TemplateAttributeResolverInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

class MemberController
{
    public function __construct(
        private readonly ContactRepositoryInterface $contactRepository,
        private readonly TemplateAttributeResolverInterface $resolver,
        private readonly Environment $twig,
    ) {
    }

    #[Route(path: [
        'de' => '/mitglieder/{id}/{slug}',
        'en' => '/members/{id}/{slug}',
    ], name: 'app_member', requirements: ['id' => '\d+'], defaults: ['slug' => 'member'])]
    public function indexAction(int $id, Request $request): Response
    {
        $contact = $this->contactRepository->findById($id);

        // Nur Mitglieder mit gesetztem Status und Anzeigetyp anzeigen
        if (0 === $contact->getDisplayType()
            || null === $contact->getDisplayType()
            || 0 === strlen($contact->getMemberStatus())
        ) {
            return new RedirectResponse('/');
        }

        return new Response($this->twig->render(
            'pages/member.html.twig',
            $this->resolver->resolve([
                'member' => $contact,
            ])
        ));
    }
}
```

### Erklärung

- Der Controller nutzt Sulus `ContactRepositoryInterface`, um den erweiterten Kontakt zu laden
- Mitglieder ohne `displayType` oder `memberStatus` werden per Redirect geschützt
- Der `TemplateAttributeResolver` stellt sicher, dass alle Sulu-Template-Variablen (z.B. `content`, `extension`) verfügbar sind
- Die Route ist mehrsprachig konfiguriert (`/mitglieder/` bzw. `/members/`)

## Beispiel-Template

```twig
{% extends "body.html.twig" %}

{% set membersSettings = association_contacts_settings() %}

{% block content %}
    {# Mitgliedsname basierend auf Anzeigetyp #}
    {% if member.displayType == 2 %}
        {% set memberName = member.fullname %}
    {% else %}
        {% set memberName = member.firstname %}
    {% endif %}

    {# Status als lesbaren Text #}
    {% set statusText = association_single_member_status(member.memberStatus) %}

    <h1>{{ statusText }} {{ memberName }}</h1>

    {# Mitglied-seit-Datum #}
    {% if member.memberSince|length > 0 %}
        <p>Mitglied seit {{ member.memberSince|format_datetime('medium', 'none', locale=app.request.locale) }}</p>
    {% endif %}

    {# Aktiv/Inaktiv #}
    {% if member.activeMember %}
        <span>Aktives Mitglied</span>
    {% endif %}

    {# Mitgliedschaft ruht #}
    {% if member.membershipSuspended and member.membershipSuspendedSince %}
        <p>Mitgliedschaft ruht seit {{ member.membershipSuspendedSince|format_datetime('medium', 'none', locale=app.request.locale) }}</p>
    {% endif %}

    {# Verstorben #}
    {% if member.deceased and member.deceasedDate %}
        <p>Verstorben am {{ member.deceasedDate|format_datetime('medium', 'none', locale=app.request.locale) }}</p>
    {% endif %}

    {# Anmerkungen zur Mitgliedschaft #}
    {% if member.membershipNotes|length > 0 %}
        {{ member.membershipNotes|raw }}
    {% endif %}

    {# Persönliche Motivation #}
    {% if member.motivation|length > 0 %}
        {{ member.motivation|raw }}
    {% endif %}

    {# Persönliche Anmerkungen #}
    {% if member.annotations|length > 0 %}
        {{ member.annotations|raw }}
    {% endif %}
{% endblock %}
```

## Verfügbare Twig-Funktionen

| Funktion | Beschreibung |
|---|---|
| `association_contacts_settings()` | Lädt die Bundle-Einstellungen (Toggles, Seitenverweise) |
| `association_all_member_status()` | Gibt alle Status-Optionen als Array zurück |
| `association_single_member_status(key)` | Gibt den übersetzten Langnamen für einen Status-Kurzschlüssel zurück |
| `association_sorted_members(members)` | Gruppiert und sortiert Mitglieder nach Status |

## Mitglieder-Übersicht mit Gruppierung

Für Übersichtsseiten, auf denen Mitglieder nach Status gruppiert werden sollen:

```twig
{% set sorted_members = association_sorted_members(members) %}
{% for group in sorted_members %}
    {% if group.members|length > 0 %}
        <h2>{{ group.title }}</h2>
        {% for member in group.members %}
            <div>{{ member.restrictedName }}</div>
        {% endfor %}
    {% endif %}
{% endfor %}
```

Die Funktion `association_sorted_members()` filtert automatisch Mitglieder mit `displayType == 0` heraus und sortiert die Gruppen in der Reihenfolge der Status-Konfiguration.
