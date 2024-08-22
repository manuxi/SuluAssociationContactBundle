<?php

namespace Manuxi\SuluAssociationContactBundle\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Sulu\Bundle\ContactBundle\Entity\Contact as SuluContact;

/**
 * @ORM\Entity()
 * @ORM\Table(name="co_contacts")
 */
class Contact extends SuluContact
{

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $memberStatus = null;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?DateTimeImmutable $memberSince = null;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $activeMember = false;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $membershipSuspended = false;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?DateTimeImmutable $membershipSuspendedSince = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $membershipNotes = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $memberPrefix = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $memberSuffix = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $annotations = null;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $deceased = false;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $displayType = null;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?DateTimeImmutable $deceasedDate = null;

    private string $locale = 'de';

    public function getMemberStatus(): ?string
    {
        return $this->memberStatus;
    }

    public function setMemberStatus(?string $memberStatus): void
    {
        $this->memberStatus = $memberStatus;
    }

    public function getMemberSince(): ?DateTimeImmutable
    {
        return $this->memberSince;
    }

    public function setMemberSince(?DateTimeImmutable $memberSince): void
    {
        $this->memberSince = $memberSince;
    }

    public function isActiveMember(): bool
    {
        return $this->activeMember;
    }

    public function setActiveMember(bool $activeMember): void
    {
        $this->activeMember = $activeMember;
    }

    public function isMembershipSuspended(): bool
    {
        return $this->membershipSuspended;
    }

    public function setMembershipSuspended(bool $membershipSuspended): void
    {
        $this->membershipSuspended = $membershipSuspended;
    }

    public function getMembershipSuspendedSince(): ?DateTimeImmutable
    {
        return $this->membershipSuspendedSince;
    }

    public function setMembershipSuspendedSince(?DateTimeImmutable $membershipSuspendedSince): void
    {
        $this->membershipSuspendedSince = $membershipSuspendedSince;
    }

    public function getMembershipNotes(): ?string
    {
        return $this->membershipNotes;
    }

    public function setMembershipNotes(?string $membershipNotes): void
    {
        $this->membershipNotes = $membershipNotes;
    }

    public function getMemberPrefix(): ?string
    {
        return $this->memberPrefix;
    }

    public function setMemberPrefix(?string $memberPrefix): void
    {
        $this->memberPrefix = $memberPrefix;
    }

    public function getMemberSuffix(): ?string
    {
        return $this->memberSuffix;
    }

    public function setMemberSuffix(?string $memberSuffix): void
    {
        $this->memberSuffix = $memberSuffix;
    }

    public function getAnnotations(): ?string
    {
        return $this->annotations;
    }

    public function setAnnotations(?string $annotations): void
    {
        $this->annotations = $annotations;
    }

    public function getMotivation(): ?string
    {
        return $this->motivation;
    }

    public function setMotivation(?string $motivation): void
    {
        $this->motivation = $motivation;
    }

    public function isDeceased(): bool
    {
        return $this->deceased;
    }

    public function setDeceased(bool $deceased): void
    {
        $this->deceased = $deceased;
    }

    public function getDeceasedDate(): ?DateTimeImmutable
    {
        return $this->deceasedDate;
    }

    public function setDeceasedDate(?DateTimeImmutable $deceasedDate): void
    {
        $this->deceasedDate = $deceasedDate;
    }

    public function getDisplayType(): ?int
    {
        return $this->displayType;
    }

    public function setDisplayType(?int $displayType): void
    {
        $this->displayType = $displayType;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;
    }

    public function getRoutePath(): string
    {
        return sprintf("%s/%s/%s", $this->getLocale() == 'en' ? 'members' : 'mitglieder', $this->getId(), urlencode($this->getRestrictedName()));
    }

    public function getRestrictedName(): ?string
    {
        return match ($this->getDisplayType()) {
            1 => $this->getFirstName(),
            2 => $this->getFullName(),
            default => null,
        };
    }
}