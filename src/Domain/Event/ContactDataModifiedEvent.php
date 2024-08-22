<?php

namespace Manuxi\SuluAssociationContactBundle\Domain\Event;

use Sulu\Bundle\ContactBundle\Domain\Event\ContactModifiedEvent;

class ContactDataModifiedEvent extends ContactModifiedEvent
{
    public function getEventType(): string
    {
        return 'modified_data';
    }
}