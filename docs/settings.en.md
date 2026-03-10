# Settings

The bundle settings are accessible in the Sulu admin under **Contacts > Settings**.
![Settings](img/settings.de.png)

## General Settings

| Field | Description |
|---|---|
| **Display Header** | Toggles the header in the detail view on/off |
| **Display Default Hero** | Toggles the hero section in the detail view on/off |
| **Display Breadcrumbs** | Toggles the breadcrumb navigation in the detail view on/off |

## Target Pages for Breadcrumbs

Here you can assign individual overview pages for each member status. These are used, for example, in the breadcrumb navigation on member detail pages.

| Field | Description |
|---|---|
| **Overview page All Members** | Main page for all members |
| **Overview page Active Members** | Target page for active members |
| **Overview page Passive Members** | Target page for passive members |
| **Overview page Honorary Members** | Target page for honorary members |
| **Overview page Supporting Members** | Target page for supporting members |
| **Overview page Founding Members** | Target page for founding members |
| **Overview page Youth Members** | Target page for youth members |
| **Overview page Board Members** | Target page for board members |
| **Overview page Probationary Members** | Target page for probationary members |
| **Overview page External Members** | Target page for external members |
| **Overview page Dormant Members** | Target page for dormant members |
| **Overview page Guest Members** | Target page for guest members |

## Twig Access

Settings can be accessed in Twig templates via the `association_contacts_settings()` function:

```twig
{% set settings = association_contacts_settings() %}

{% if settings.toggleHeader %}
    {# Show header #}
{% endif %}

{% set breadcrumbPage = settings.pageMembersActive %}
```
