<?php

declare(strict_types=1);

namespace Manuxi\SuluAssociationContactBundle\Tests\Unit\Entity;

use Manuxi\SuluAssociationContactBundle\Entity\Contact;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Contact::class)]
class ContactTest extends TestCase
{
    private Contact $contact;

    protected function setUp(): void
    {
        $this->contact = new Contact();
    }

    public function testDefaultValues(): void
    {
        self::assertNull($this->contact->getMemberStatus());
        self::assertNull($this->contact->getMemberSince());
        self::assertFalse($this->contact->isActiveMember());
        self::assertFalse($this->contact->isMembershipSuspended());
        self::assertNull($this->contact->getMembershipSuspendedSince());
        self::assertNull($this->contact->getMembershipNotes());
        self::assertNull($this->contact->getMemberPrefix());
        self::assertNull($this->contact->getMemberSuffix());
        self::assertNull($this->contact->getMotivation());
        self::assertNull($this->contact->getAnnotations());
        self::assertFalse($this->contact->isDeceased());
        self::assertNull($this->contact->getDeceasedDate());
        self::assertNull($this->contact->getDisplayType());
        self::assertSame('de', $this->contact->getLocale());
    }

    public function testMemberStatus(): void
    {
        $this->contact->setMemberStatus('AM');
        self::assertSame('AM', $this->contact->getMemberStatus());

        $this->contact->setMemberStatus(null);
        self::assertNull($this->contact->getMemberStatus());
    }

    public function testMemberSince(): void
    {
        $date = new \DateTimeImmutable('2024-01-15');
        $this->contact->setMemberSince($date);
        self::assertSame($date, $this->contact->getMemberSince());

        $this->contact->setMemberSince(null);
        self::assertNull($this->contact->getMemberSince());
    }

    public function testActiveMember(): void
    {
        $this->contact->setActiveMember(true);
        self::assertTrue($this->contact->isActiveMember());

        $this->contact->setActiveMember(false);
        self::assertFalse($this->contact->isActiveMember());
    }

    public function testMembershipSuspended(): void
    {
        $this->contact->setMembershipSuspended(true);
        self::assertTrue($this->contact->isMembershipSuspended());

        $date = new \DateTimeImmutable('2025-06-01');
        $this->contact->setMembershipSuspendedSince($date);
        self::assertSame($date, $this->contact->getMembershipSuspendedSince());
    }

    public function testMembershipNotes(): void
    {
        $this->contact->setMembershipNotes('<p>Some notes</p>');
        self::assertSame('<p>Some notes</p>', $this->contact->getMembershipNotes());
    }

    public function testMemberPrefixAndSuffix(): void
    {
        $this->contact->setMemberPrefix('Dr.');
        $this->contact->setMemberSuffix('M.Sc.');
        self::assertSame('Dr.', $this->contact->getMemberPrefix());
        self::assertSame('M.Sc.', $this->contact->getMemberSuffix());
    }

    public function testMotivationAndAnnotations(): void
    {
        $this->contact->setMotivation('Helping the community');
        $this->contact->setAnnotations('Reliable member');
        self::assertSame('Helping the community', $this->contact->getMotivation());
        self::assertSame('Reliable member', $this->contact->getAnnotations());
    }

    public function testDeceased(): void
    {
        $this->contact->setDeceased(true);
        self::assertTrue($this->contact->isDeceased());

        $date = new \DateTimeImmutable('2025-03-01');
        $this->contact->setDeceasedDate($date);
        self::assertSame($date, $this->contact->getDeceasedDate());
    }

    public function testDisplayType(): void
    {
        $this->contact->setDisplayType(1);
        self::assertSame(1, $this->contact->getDisplayType());

        $this->contact->setDisplayType(null);
        self::assertNull($this->contact->getDisplayType());
    }

    public function testLocale(): void
    {
        $this->contact->setLocale('en');
        self::assertSame('en', $this->contact->getLocale());
    }

    #[DataProvider('displayTypeProvider')]
    public function testGetRestrictedName(int $displayType, ?string $expected): void
    {
        $this->contact->setFirstName('Max');
        $this->contact->setLastName('Mustermann');
        $this->contact->setDisplayType($displayType);

        self::assertSame($expected, $this->contact->getRestrictedName());
    }

    /**
     * @return array<string, array{int, ?string}>
     */
    public static function displayTypeProvider(): array
    {
        return [
            'no display' => [0, null],
            'first name only' => [1, 'Max'],
            'full name' => [2, 'Max Mustermann'],
        ];
    }

    public function testGetRoutePath(): void
    {
        $this->setContactId(42);
        $this->contact->setFirstName('Max');
        $this->contact->setLastName('Mustermann');
        $this->contact->setDisplayType(2);
        $this->contact->setLocale('de');

        $path = $this->contact->getRoutePath();
        self::assertStringContainsString('mitglieder', $path);
        self::assertStringContainsString('42', $path);
        self::assertStringContainsString('Max', $path);
    }

    public function testGetRoutePathEnglish(): void
    {
        $this->setContactId(42);
        $this->contact->setFirstName('Max');
        $this->contact->setLastName('Mustermann');
        $this->contact->setDisplayType(2);
        $this->contact->setLocale('en');

        $path = $this->contact->getRoutePath();
        self::assertStringContainsString('members', $path);
    }

    private function setContactId(int $id): void
    {
        $reflection = new \ReflectionClass(\Sulu\Bundle\ContactBundle\Entity\Contact::class);
        $property = $reflection->getProperty('id');
        $property->setValue($this->contact, $id);
    }
}
