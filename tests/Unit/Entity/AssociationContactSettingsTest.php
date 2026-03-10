<?php

declare(strict_types=1);

namespace Manuxi\SuluAssociationContactBundle\Tests\Unit\Entity;

use Manuxi\SuluAssociationContactBundle\Entity\AssociationContactSettings;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AssociationContactSettings::class)]
class AssociationContactSettingsTest extends TestCase
{
    private AssociationContactSettings $settings;

    protected function setUp(): void
    {
        $this->settings = new AssociationContactSettings();
    }

    public function testConstants(): void
    {
        self::assertSame('association_contact_settings', AssociationContactSettings::RESOURCE_KEY);
        self::assertSame('association_contact_settings', AssociationContactSettings::FORM_KEY);
        self::assertSame('sulu.contacts.settings', AssociationContactSettings::SECURITY_CONTEXT);
    }

    public function testDefaultValues(): void
    {
        self::assertNull($this->settings->getId());
        self::assertNull($this->settings->getToggleHeader());
        self::assertNull($this->settings->getToggleHero());
        self::assertNull($this->settings->getToggleBreadcrumbs());
        self::assertNull($this->settings->getPageMembers());
    }

    public function testToggleFields(): void
    {
        $this->settings->setToggleHeader(true);
        $this->settings->setToggleHero(false);
        $this->settings->setToggleBreadcrumbs(true);

        self::assertTrue($this->settings->getToggleHeader());
        self::assertFalse($this->settings->getToggleHero());
        self::assertTrue($this->settings->getToggleBreadcrumbs());
    }

    public function testPageMemberFields(): void
    {
        $fields = [
            'PageMembers' => '/members',
            'PageMembersActive' => '/members/active',
            'PageMembersPassive' => '/members/passive',
            'PageMembersHonorary' => '/members/honorary',
            'PageMembersSupporting' => '/members/supporting',
            'PageMembersFounding' => '/members/founding',
            'PageMembersYouth' => '/members/youth',
            'PageMembersBoard' => '/members/board',
            'PageMembersProbationary' => '/members/probationary',
            'PageMembersExternal' => '/members/external',
            'PageMembersDormant' => '/members/dormant',
            'PageMembersGuest' => '/members/guest',
        ];

        foreach ($fields as $field => $value) {
            $setter = 'set' . $field;
            $getter = 'get' . $field;

            $this->settings->$setter($value);
            self::assertSame($value, $this->settings->$getter(), "Failed for field: {$field}");
        }
    }

    public function testNullablePageFields(): void
    {
        $this->settings->setPageMembers('/members');
        self::assertSame('/members', $this->settings->getPageMembers());

        $this->settings->setPageMembers(null);
        self::assertNull($this->settings->getPageMembers());
    }
}
