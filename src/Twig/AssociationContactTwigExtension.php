<?php

namespace Manuxi\SuluAssociationContactBundle\Twig;

use Manuxi\SuluAssociationContactBundle\Content\Select\ContactStatusSelect;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AssociationContactTwigExtension extends AbstractExtension
{

    private ContactStatusSelect $contactStatusSelect;

    public function __construct(ContactStatusSelect $contactStatusSelect)
    {
        $this->contactStatusSelect = $contactStatusSelect;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('association_all_member_status', [$this, 'getAllMemberStatus']),
            new TwigFunction('association_single_member_status', [$this, 'getMemberStatus']),
            new TwigFunction('association_sorted_members', [$this, 'getSortedMembers']),
        ];
    }

    public function getAllMemberStatus(): array
    {
        return $this->contactStatusSelect->getValues();
    }

    public function getMemberStatus(string $key): string
    {
        return $this->contactStatusSelect->getValue($key);
    }

    public function getSortedMembers(array $members): array
    {
        $newValues = [];
        $values = $this->contactStatusSelect->getIndexedValuesPlural();

        foreach($members as $member) {
            if ($member->getDisplayType() != 0) {
                $short = $member->getMemberStatus();
                $newValues[$short]['members'][] = $member;
                if (!isset($newValues[$short]['title'])) {
                    $newValues[$short]['title'] = $values[$short];
                }
            }
        }

        //sort by order of getIndexedValuesPlural()
        $keys = array_intersect_key($values, $newValues);
        $newValues = array_replace($keys, $newValues);
        
        return $newValues;
    }
}
