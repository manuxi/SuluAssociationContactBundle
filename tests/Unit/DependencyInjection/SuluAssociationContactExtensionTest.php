<?php

declare(strict_types=1);

namespace Manuxi\SuluAssociationContactBundle\Tests\Unit\DependencyInjection;

use Manuxi\SuluAssociationContactBundle\DependencyInjection\SuluAssociationContactExtension;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(SuluAssociationContactExtension::class)]
class SuluAssociationContactExtensionTest extends TestCase
{
    private SuluAssociationContactExtension $extension;

    protected function setUp(): void
    {
        $this->extension = new SuluAssociationContactExtension();
    }

    public function testPrependRegistersSuluAdminConfig(): void
    {
        $container = $this->createMock(ContainerBuilder::class);
        $container->method('hasExtension')->willReturnMap([
            ['sulu_admin', true],
            ['sulu_contact', true],
        ]);

        $prependedConfigs = [];
        $container->method('prependExtensionConfig')
            ->willReturnCallback(function (string $name, array $config) use (&$prependedConfigs) {
                $prependedConfigs[$name][] = $config;
            });

        $container->method('loadFromExtension');

        $this->extension->prepend($container);

        // Check sulu_admin resources
        self::assertArrayHasKey('sulu_admin', $prependedConfigs);
        $adminConfig = $prependedConfigs['sulu_admin'][0];

        self::assertArrayHasKey('resources', $adminConfig);
        self::assertArrayHasKey('association_contact', $adminConfig['resources']);
        self::assertArrayHasKey('association_contact_settings', $adminConfig['resources']);

        self::assertSame(
            'sulu_association_contact.get',
            $adminConfig['resources']['association_contact']['routes']['detail']
        );
        self::assertSame(
            'sulu_association_contact.get_settings',
            $adminConfig['resources']['association_contact_settings']['routes']['detail']
        );

        // Check forms and lists directories
        self::assertArrayHasKey('forms', $adminConfig);
        self::assertArrayHasKey('lists', $adminConfig);
    }

    public function testPrependRegistersContactEntityOverride(): void
    {
        $container = $this->createMock(ContainerBuilder::class);
        $container->method('hasExtension')->willReturnMap([
            ['sulu_admin', false],
            ['sulu_contact', true],
        ]);

        $prependedConfigs = [];
        $container->method('prependExtensionConfig')
            ->willReturnCallback(function (string $name, array $config) use (&$prependedConfigs) {
                $prependedConfigs[$name][] = $config;
            });

        $container->method('loadFromExtension');

        $this->extension->prepend($container);

        self::assertArrayHasKey('sulu_contact', $prependedConfigs);
        $contactConfig = $prependedConfigs['sulu_contact'][0];

        self::assertSame(
            'Manuxi\SuluAssociationContactBundle\Entity\Contact',
            $contactConfig['objects']['contact']['model']
        );
    }

    public function testPrependRegistersTranslations(): void
    {
        $container = $this->createMock(ContainerBuilder::class);
        $container->method('hasExtension')->willReturn(false);

        $frameworkConfig = null;
        $container->method('loadFromExtension')
            ->willReturnCallback(function (string $name, array $config) use (&$frameworkConfig, $container) {
                if ($name === 'framework') {
                    $frameworkConfig = $config;
                }

                return $container;
            });

        $this->extension->prepend($container);

        self::assertNotNull($frameworkConfig);
        self::assertSame('en', $frameworkConfig['default_locale']);
        self::assertCount(1, $frameworkConfig['translator']['paths']);
    }
}
