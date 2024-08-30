<?php

namespace Manuxi\SuluAssociationContactBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sulu\Component\Persistence\Model\AuditableInterface;
use Sulu\Component\Persistence\Model\AuditableTrait;

#[ORM\Entity]
#[ORM\Table(name: 'app_association_contact_settings')]
class AssociationContactSettings implements AuditableInterface
{
    use AuditableTrait;

    public const RESOURCE_KEY = 'association_contact_settings';
    public const FORM_KEY = 'association_contact_settings';
    public const SECURITY_CONTEXT = 'sulu.settings.app_settings_members';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true)]
    private ?bool $toggleHeader = null;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true)]
    private ?bool $toggleHero = null;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true)]
    private ?bool $toggleBreadcrumbs = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $pageMembers = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $pageMembersGuest = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $pageMembersActive = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $pageMembersPassive = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $pageMembersHonorary = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $pageMembersSupporting = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $pageMembersFounding = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $pageMembersYouth = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $pageMembersBoard = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $pageMembersProbationary = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $pageMembersExternal = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $pageMembersDormant = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToggleHeader(): ?bool
    {
        return $this->toggleHeader;
    }

    public function setToggleHeader(?bool $toggleHeader): void
    {
        $this->toggleHeader = $toggleHeader;
    }

    public function getToggleHero(): ?bool
    {
        return $this->toggleHero;
    }

    public function setToggleHero(?bool $toggleHero): void
    {
        $this->toggleHero = $toggleHero;
    }

    public function getToggleBreadcrumbs(): ?bool
    {
        return $this->toggleBreadcrumbs;
    }

    public function setToggleBreadcrumbs(?bool $toggleBreadcrumbs): void
    {
        $this->toggleBreadcrumbs = $toggleBreadcrumbs;
    }

    public function getPageMembers(): ?string
    {
        return $this->pageMembers;
    }

    public function setPageMembers(?string $pageMembers): void
    {
        $this->pageMembers = $pageMembers;
    }

    public function getPageMembersGuest(): ?string
    {
        return $this->pageMembersGuest;
    }

    public function setPageMembersGuest(?string $pageMembersGuest): void
    {
        $this->pageMembersGuest = $pageMembersGuest;
    }

    public function getPageMembersActive(): ?string
    {
        return $this->pageMembersActive;
    }

    public function setPageMembersActive(?string $pageMembersActive): void
    {
        $this->pageMembersActive = $pageMembersActive;
    }

    public function getPageMembersPassive(): ?string
    {
        return $this->pageMembersPassive;
    }

    public function setPageMembersPassive(?string $pageMembersPassive): void
    {
        $this->pageMembersPassive = $pageMembersPassive;
    }

    public function getPageMembersHonorary(): ?string
    {
        return $this->pageMembersHonorary;
    }

    public function setPageMembersHonorary(?string $pageMembersHonorary): void
    {
        $this->pageMembersHonorary = $pageMembersHonorary;
    }

    public function getPageMembersSupporting(): ?string
    {
        return $this->pageMembersSupporting;
    }

    public function setPageMembersSupporting(?string $pageMembersSupporting): void
    {
        $this->pageMembersSupporting = $pageMembersSupporting;
    }

    public function getPageMembersFounding(): ?string
    {
        return $this->pageMembersFounding;
    }

    public function setPageMembersFounding(?string $pageMembersFounding): void
    {
        $this->pageMembersFounding = $pageMembersFounding;
    }

    public function getPageMembersYouth(): ?string
    {
        return $this->pageMembersYouth;
    }

    public function setPageMembersYouth(?string $pageMembersYouth): void
    {
        $this->pageMembersYouth = $pageMembersYouth;
    }

    public function getPageMembersBoard(): ?string
    {
        return $this->pageMembersBoard;
    }

    public function setPageMembersBoard(?string $pageMembersBoard): void
    {
        $this->pageMembersBoard = $pageMembersBoard;
    }

    public function getPageMembersProbationary(): ?string
    {
        return $this->pageMembersProbationary;
    }

    public function setPageMembersProbationary(?string $pageMembersProbationary): void
    {
        $this->pageMembersProbationary = $pageMembersProbationary;
    }

    public function getPageMembersExternal(): ?string
    {
        return $this->pageMembersExternal;
    }

    public function setPageMembersExternal(?string $pageMembersExternal): void
    {
        $this->pageMembersExternal = $pageMembersExternal;
    }

    public function getPageMembersDormant(): ?string
    {
        return $this->pageMembersDormant;
    }

    public function setPageMembersDormant(?string $pageMembersDormant): void
    {
        $this->pageMembersDormant = $pageMembersDormant;
    }



}