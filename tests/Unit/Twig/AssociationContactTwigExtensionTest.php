<?php

declare(strict_types=1);

namespace Manuxi\SuluAssociationContactBundle\Tests\Unit\Twig;

use Manuxi\SuluAssociationContactBundle\Content\Select\ContactStatusSelect;
use Manuxi\SuluAssociationContactBundle\Entity\Contact;
use Manuxi\SuluAssociationContactBundle\Twig\AssociationContactTwigExtension;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AssociationContactTwigExtension::class)]
class AssociationContactTwigExtensionTest extends TestCase
{
    private AssociationContactTwigExtension $extension;
    private ContactStatusSelect $statusSelect;

    protected function setUp(): void
    {
        $this->statusSelect = $this->createMock(ContactStatusSelect::class);
        $this->extension = new AssociationContactTwigExtension($this->statusSelect);
    }

    public function testGetFunctions(): void
    {
        $functions = $this->extension->getFunctions();

        self::assertCount(3, $functions);

        $functionNames = array_map(fn ($f) => $f->getName(), $functions);
        self::assertContains('association_all_member_status', $functionNames);
        self::assertContains('association_single_member_status', $functionNames);
        self::assertContains('association_sorted_members', $functionNames);
    }

    public function testGetAllMemberStatus(): void
    {
        $expected = [['name' => 'AM', 'title' => 'Active', 'descr' => 'Active Members']];
        $this->statusSelect->method('getValues')->willReturn($expected);

        self::assertSame($expected, $this->extension->getAllMemberStatus());
    }

    public function testGetMemberStatus(): void
    {
        $this->statusSelect->method('getValue')
            ->with('AM')
            ->willReturn('Active Member');

        self::assertSame('Active Member', $this->extension->getMemberStatus('AM'));
    }

    public function testGetSortedMembersExcludesHiddenMembers(): void
    {
        $hiddenMember = $this->createMock(Contact::class);
        $hiddenMember->method('getDisplayType')->willReturn(0);

        $this->statusSelect->method('getIndexedValuesPlural')->willReturn([]);

        $result = $this->extension->getSortedMembers([$hiddenMember]);
        self::assertEmpty($result);
    }

    public function testGetSortedMembersGroupsByStatus(): void
    {
        $member1 = $this->createMock(Contact::class);
        $member1->method('getDisplayType')->willReturn(1);
        $member1->method('getMemberStatus')->willReturn('AM');

        $member2 = $this->createMock(Contact::class);
        $member2->method('getDisplayType')->willReturn(2);
        $member2->method('getMemberStatus')->willReturn('AM');

        $member3 = $this->createMock(Contact::class);
        $member3->method('getDisplayType')->willReturn(1);
        $member3->method('getMemberStatus')->willReturn('PM');

        $this->statusSelect->method('getIndexedValuesPlural')->willReturn([
            'AM' => 'Active Members',
            'PM' => 'Passive Members',
        ]);

        $result = $this->extension->getSortedMembers([$member1, $member2, $member3]);

        self::assertCount(2, $result);
        self::assertArrayHasKey('AM', $result);
        self::assertArrayHasKey('PM', $result);
        self::assertCount(2, $result['AM']['members']);
        self::assertCount(1, $result['PM']['members']);
        self::assertSame('Active Members', $result['AM']['title']);
        self::assertSame('Passive Members', $result['PM']['title']);
    }
}
