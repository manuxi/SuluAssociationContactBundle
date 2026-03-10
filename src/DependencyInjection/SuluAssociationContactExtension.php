<?php

declare(strict_types=1);

namespace Manuxi\SuluAssociationContactBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class SuluAssociationContactExtension extends Extension implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container): void
    {
        if ($container->hasExtension('sulu_admin')) {
            $container->prependExtensionConfig('sulu_admin', [
                'lists' => [
                    'directories' => [
                        __DIR__ . '/../Resources/config/lists',
                    ],
                ],
                'forms' => [
                    'directories' => [
                        __DIR__ . '/../Resources/config/forms',
                    ],
                ],
                'resources' => [
                    'association_contact' => [
                        'routes' => [
                            'detail' => 'sulu_association_contact.get',
                        ],
                    ],
                    'association_contact_settings' => [
                        'routes' => [
                            'detail' => 'sulu_association_contact.get_settings',
                        ],
                    ],
                ],
            ]);
        }

        if ($container->hasExtension('sulu_contact')) {
            $container->prependExtensionConfig('sulu_contact', [
                'objects' => [
                    'contact' => [
                        'model' => 'Manuxi\SuluAssociationContactBundle\Entity\Contact',
                    ],
                ],
            ]);
        }

        $container->loadFromExtension('framework', [
            'default_locale' => 'en',
            'translator' => [
                'paths' => [__DIR__ . '/../Resources/translations/'],
            ],
        ]);
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        $loader->load('services.yaml');
    }
}
