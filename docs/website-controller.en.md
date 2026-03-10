# Website Controller

This bundle does not provide its own website controller. The rendering of members on the website is implemented in the respective Sulu application.

## Example Controller

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

        // Only show members with a set status and display type
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

### Explanation

- The controller uses Sulu's `ContactRepositoryInterface` to load the extended contact entity
- Members without `displayType` or `memberStatus` are protected via redirect
- The `TemplateAttributeResolver` ensures all Sulu template variables (e.g. `content`, `extension`) are available
- The route is configured for multiple locales (`/mitglieder/` and `/members/`)

## Example Template

```twig
{% extends "body.html.twig" %}

{% set membersSettings = association_contacts_settings() %}

{% block content %}
    {# Member name based on display type #}
    {% if member.displayType == 2 %}
        {% set memberName = member.fullname %}
    {% else %}
        {% set memberName = member.firstname %}
    {% endif %}

    {# Status as readable text #}
    {% set statusText = association_single_member_status(member.memberStatus) %}

    <h1>{{ statusText }} {{ memberName }}</h1>

    {# Member since date #}
    {% if member.memberSince|length > 0 %}
        <p>Member since {{ member.memberSince|format_datetime('medium', 'none', locale=app.request.locale) }}</p>
    {% endif %}

    {# Active/inactive #}
    {% if member.activeMember %}
        <span>Active member</span>
    {% endif %}

    {# Membership suspended #}
    {% if member.membershipSuspended and member.membershipSuspendedSince %}
        <p>Membership suspended since {{ member.membershipSuspendedSince|format_datetime('medium', 'none', locale=app.request.locale) }}</p>
    {% endif %}

    {# Deceased #}
    {% if member.deceased and member.deceasedDate %}
        <p>Deceased on {{ member.deceasedDate|format_datetime('medium', 'none', locale=app.request.locale) }}</p>
    {% endif %}

    {# Membership notes #}
    {% if member.membershipNotes|length > 0 %}
        {{ member.membershipNotes|raw }}
    {% endif %}

    {# Personal motivation #}
    {% if member.motivation|length > 0 %}
        {{ member.motivation|raw }}
    {% endif %}

    {# Personal annotations #}
    {% if member.annotations|length > 0 %}
        {{ member.annotations|raw }}
    {% endif %}
{% endblock %}
```

## Available Twig Functions

| Function | Description |
|---|---|
| `association_contacts_settings()` | Loads the bundle settings (toggles, page references) |
| `association_all_member_status()` | Returns all status options as an array |
| `association_single_member_status(key)` | Returns the translated long name for a status short key |
| `association_sorted_members(members)` | Groups and sorts members by status |

## Member Overview with Grouping

For overview pages where members should be grouped by status:

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

The `association_sorted_members()` function automatically filters out members with `displayType == 0` and sorts the groups in the order of the status configuration.
