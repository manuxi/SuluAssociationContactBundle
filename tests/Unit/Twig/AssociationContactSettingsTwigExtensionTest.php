<?php

declare(strict_types=1);

namespace Manuxi\SuluAssociationContactBundle\Tests\Unit\Twig;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Manuxi\SuluAssociationContactBundle\Entity\AssociationContactSettings;
use Manuxi\SuluAssociationContactBundle\Twig\AssociationContactSettingsTwigExtension;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AssociationContactSettingsTwigExtension::class)]
class AssociationContactSettingsTwigExtensionTest extends TestCase
{
    private AssociationContactSettingsTwigExtension $extension;
    private EntityRepository $repository;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(EntityRepository::class);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->method('getRepository')
            ->with(AssociationContactSettings::class)
            ->willReturn($this->repository);

        $this->extension = new AssociationContactSettingsTwigExtension($entityManager);
    }

    public function testGetFunctions(): void
    {
        $functions = $this->extension->getFunctions();

        self::assertCount(1, $functions);
        self::assertSame('association_contacts_settings', $functions[0]->getName());
    }

    public function testLoadSettingsReturnsExistingEntity(): void
    {
        $settings = new AssociationContactSettings();
        $settings->setToggleHeader(true);

        $this->repository->method('findOneBy')->with([])->willReturn($settings);

        $result = $this->extension->loadAssociationContactSettings();
        self::assertSame($settings, $result);
        self::assertTrue($result->getToggleHeader());
    }

    public function testLoadSettingsReturnsNewEntityWhenNoneExists(): void
    {
        $this->repository->method('findOneBy')->with([])->willReturn(null);

        $result = $this->extension->loadAssociationContactSettings();
        self::assertInstanceOf(AssociationContactSettings::class, $result);
        self::assertNull($result->getId());
    }
}
