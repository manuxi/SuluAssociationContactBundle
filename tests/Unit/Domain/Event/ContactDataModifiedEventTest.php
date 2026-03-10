<?php

declare(strict_types=1);

namespace Manuxi\SuluAssociationContactBundle\Tests\Unit\Domain\Event;

use Manuxi\SuluAssociationContactBundle\Domain\Event\ContactDataModifiedEvent;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ContactDataModifiedEvent::class)]
class ContactDataModifiedEventTest extends TestCase
{
    public function testGetEventType(): void
    {
        $event = $this->createPartialMock(ContactDataModifiedEvent::class, []);

        self::assertSame('modified_data', $event->getEventType());
    }
}
