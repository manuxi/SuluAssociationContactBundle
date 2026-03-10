<?php

declare(strict_types=1);

namespace Manuxi\SuluAssociationContactBundle\Tests\Unit\Content\Select;

use Manuxi\SuluAssociationContactBundle\Content\Select\ContactStatusSelect;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Translation\TranslatorInterface;

#[CoversClass(ContactStatusSelect::class)]
class ContactStatusSelectTest extends TestCase
{
    private ContactStatusSelect $statusSelect;

    protected function setUp(): void
    {
        $translator = $this->createMock(TranslatorInterface::class);
        $translator->method('trans')
            ->willReturnCallback(fn (string $id) => $id);

        $this->statusSelect = new ContactStatusSelect($translator);
    }

    public function testGetDefaultValue(): void
    {
        self::assertSame('association_contact.status.short.active', $this->statusSelect->getDefaultValue());
    }

    public function testGetValues(): void
    {
        $values = $this->statusSelect->getValues();

        self::assertIsArray($values);
        self::assertCount(12, $values); // 11 statuses + 1 empty

        // Check structure of first entry
        self::assertArrayHasKey('name', $values[0]);
        self::assertArrayHasKey('title', $values[0]);
        self::assertArrayHasKey('descr', $values[0]);
    }

    public function testGetValueWithShortKey(): void
    {
        $result = $this->statusSelect->getValue('association_contact.status.short.active');
        self::assertSame('association_contact.status.long.active', $result);
    }

    public function testGetValueWithUnknownKey(): void
    {
        $result = $this->statusSelect->getValue('unknown_key');
        self::assertSame('', $result);
    }

    public function testGetIndexedValues(): void
    {
        $values = $this->statusSelect->getIndexedValues();

        self::assertIsArray($values);
        self::assertCount(12, $values);
        self::assertArrayHasKey('association_contact.status.short.active', $values);
        self::assertSame(
            'association_contact.status.long.active',
            $values['association_contact.status.short.active']
        );
    }

    public function testGetIndexedValuesPlural(): void
    {
        $values = $this->statusSelect->getIndexedValuesPlural();

        self::assertIsArray($values);
        self::assertCount(12, $values);
        self::assertArrayHasKey('association_contact.status.short.active', $values);
        self::assertSame(
            'association_contact.status.plural.long.active',
            $values['association_contact.status.short.active']
        );
    }

    public function testAllStatusKeysPresent(): void
    {
        $expectedKeys = [
            'association_contact.status.short.board',
            'association_contact.status.short.honorary',
            'association_contact.status.short.supporting',
            'association_contact.status.short.founding',
            'association_contact.status.short.youth',
            'association_contact.status.short.active',
            'association_contact.status.short.passive',
            'association_contact.status.short.probationary',
            'association_contact.status.short.external',
            'association_contact.status.short.dormant',
            'association_contact.status.short.guest',
        ];

        $values = $this->statusSelect->getIndexedValues();

        foreach ($expectedKeys as $key) {
            self::assertArrayHasKey($key, $values, "Missing status key: {$key}");
        }
    }
}
