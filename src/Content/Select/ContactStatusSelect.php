<?php

declare(strict_types=1);

namespace Manuxi\SuluAssociationContactBundle\Content\Select;

use Symfony\Contracts\Translation\TranslatorInterface;

class ContactStatusSelect
{
    private TranslatorInterface $translator;
    private array $typesMap = [
        ''                                              => 'association_contact.status.none',
        'association_contact.status.short.active'       => 'association_contact.status.long.active',
        'association_contact.status.short.passive'      => 'association_contact.status.long.passive',
        'association_contact.status.short.honorary'     => 'association_contact.status.long.honorary',
        'association_contact.status.short.supporting'   => 'association_contact.status.long.supporting',
        'association_contact.status.short.founding'     => 'association_contact.status.long.founding',
        'association_contact.status.short.youth'        => 'association_contact.status.long.youth',
        'association_contact.status.short.board'        => 'association_contact.status.long.board',
        'association_contact.status.short.probationary' => 'association_contact.status.long.probationary',
        'association_contact.status.short.external'     => 'association_contact.status.long.external',
        'association_contact.status.short.dormant'      => 'association_contact.status.long.dormant',
        'association_contact.status.short.guest'        => 'association_contact.status.long.guest',
    ];
    private array $pluralTypesMap = [
        ''                                              => 'association_contact.status.none',
        'association_contact.status.short.active'       => 'association_contact.status.plural.long.active',
        'association_contact.status.short.passive'      => 'association_contact.status.plural.long.passive',
        'association_contact.status.short.honorary'     => 'association_contact.status.plural.long.honorary',
        'association_contact.status.short.supporting'   => 'association_contact.status.plural.long.supporting',
        'association_contact.status.short.founding'     => 'association_contact.status.plural.long.founding',
        'association_contact.status.short.youth'        => 'association_contact.status.plural.long.youth',
        'association_contact.status.short.board'        => 'association_contact.status.plural.long.board',
        'association_contact.status.short.probationary' => 'association_contact.status.plural.long.probationary',
        'association_contact.status.short.external'     => 'association_contact.status.plural.long.external',
        'association_contact.status.short.dormant'      => 'association_contact.status.plural.long.dormant',
        'association_contact.status.short.guest'        => 'association_contact.status.plural.long.guest',
    ];
    private array $descriptionTypesMap = [
        ''                                              => 'association_contact.status.none',
        'association_contact.status.short.active'       => 'association_contact.status.plural.long.active',
        'association_contact.status.short.passive'      => 'association_contact.status.plural.long.passive',
        'association_contact.status.short.honorary'     => 'association_contact.status.plural.long.honorary',
        'association_contact.status.short.supporting'   => 'association_contact.status.plural.long.supporting',
        'association_contact.status.short.founding'     => 'association_contact.status.plural.long.founding',
        'association_contact.status.short.youth'        => 'association_contact.status.plural.long.youth',
        'association_contact.status.short.board'        => 'association_contact.status.plural.long.board',
        'association_contact.status.short.probationary' => 'association_contact.status.plural.long.probationary',
        'association_contact.status.short.external'     => 'association_contact.status.plural.long.external',
        'association_contact.status.short.dormant'      => 'association_contact.status.plural.long.dormant',
        'association_contact.status.short.guest'        => 'association_contact.status.plural.long.guest',
    ];
    private string $defaultValue = 'association_contact.status.short.active';

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function getValue(string $key): string
    {
        foreach ($this->typesMap as $short => $long) {
            if ($short == $key || $this->translator->trans($short, [], 'admin') == $key) {
                return $this->translator->trans($long, [], 'admin');
            }
        }

        return '';
    }

    public function getValues(): array
    {
        $values = [];

        foreach ($this->typesMap as $short => $long) {
            $values[] = [
                'name'  => $this->translator->trans($short, [], 'admin'),
                'title' => $this->translator->trans($long, [], 'admin'),
                'descr' => $this->translator->trans($this->descriptionTypesMap[$short], [], 'admin'),
            ];
        }

        return $values;
    }

    public function getIndexedValues(): array
    {
        $values = [];

        foreach ($this->typesMap as $short => $long) {
            $values[$this->translator->trans($short, [], 'admin')] = $this->translator->trans($long, [], 'admin');
        }

        return $values;
    }

    public function getIndexedValuesPlural(): array
    {
        $values = [];

        foreach ($this->pluralTypesMap as $short => $long) {
            $values[$this->translator->trans($short, [], 'admin')] = $this->translator->trans($long, [], 'admin');
        }

        return $values;
    }

    public function getDefaultValue(): string
    {
        return $this->defaultValue;
    }

}