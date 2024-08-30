<?php

namespace Manuxi\SuluAssociationContactBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;

class SuluAssociationContactExtension extends Extension implements PrependExtensionInterface
{

    public function prepend(ContainerBuilder $container)
    {
        if($container->hasExtension("sulu_admin")){
            $container->prependExtensionConfig(
                "sulu_admin",
                [
                    "lists" => [
                        "directories" => [
                            __DIR__ . "/../../config/lists",
                        ],
                    ],
                    "forms" => [
                        "directories" => [
                            __DIR__ . "/../../config/forms"
                        ]
                    ],
                    "resources" => [
                        "association_contact" => [
                            "routes" => [
                                "detail" => "sulu_association_contact.get_association-contact"
                            ]
                        ],
                        "association_contact_settings" => [
                            "routes" => [
                                "detail" => 'association_contact_settings.get_association-contact-settings'
                            ]
                        ]
                    ]
                ]
            );
        }
        if($container->hasExtension("sulu_contact")){
            $container->prependExtensionConfig(
                "sulu_contact",
                [
                    "objects" => [
                        "contact" => [
                            "model" => "Manuxi\SuluAssociationContactBundle\Entity\Contact"
                        ]
                    ]
                ]
            );
        }

        $container->loadFromExtension("framework", [
            "default_locale" => "en",
            "translator" => ["paths" => [__DIR__ . "/../../translations/"]],
        ]);

    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . "/../../config"));
        $loader->load("services.xml");

    }

}