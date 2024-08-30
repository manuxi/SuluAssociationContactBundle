<?php

namespace Manuxi\SuluAssociationContactBundle\Twig;

use Doctrine\ORM\EntityManagerInterface;
use Manuxi\SuluAssociationContactBundle\Entity\AssociationContactSettings;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AssociationContactSettingsTwigExtension extends AbstractExtension
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('association_contacts_settings', [$this, 'loadAssociationContactSettings']),
        ];
    }

    public function loadAssociationContactSettings(): AssociationContactSettings
    {
        $appSettingsMembers = $this->entityManager->getRepository(AssociationContactSettings::class)->findOneBy([]) ?? null;

        return $appSettingsMembers ?: new AssociationContactSettings();
    }
}