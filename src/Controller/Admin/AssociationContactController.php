<?php

declare(strict_types=1);

namespace Manuxi\SuluAssociationContactBundle\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\View\ViewHandlerInterface;
use Manuxi\SuluAssociationContactBundle\Domain\Event\ContactDataModifiedEvent;
use Manuxi\SuluAssociationContactBundle\Entity\Contact;
use Sulu\Bundle\ActivityBundle\Application\Collector\DomainEventCollectorInterface;
use Sulu\Bundle\ContactBundle\Admin\ContactAdmin;
use Sulu\Bundle\ContactBundle\Entity\ContactInterface;
use Sulu\Component\Rest\AbstractRestController;
use Sulu\Component\Security\SecuredControllerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route(path: 'association-contact')]
class AssociationContactController extends AbstractRestController implements SecuredControllerInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly DomainEventCollectorInterface $domainEventCollector,
        ViewHandlerInterface $viewHandler,
        ?TokenStorageInterface $tokenStorage = null,
    ) {
        parent::__construct($viewHandler, $tokenStorage);
    }

    #[Route(path: '/{id}', methods: ['GET'], name: 'sulu_association_contact.get')]
    public function getAction(int $id): Response
    {
        $contact = $this->findContactOrFail($id);

        return new JsonResponse($this->getDataForEntity($contact));
    }

    #[Route(path: '/{id}', methods: ['PUT'], name: 'sulu_association_contact.put')]
    public function putAction(Request $request, int $id): Response
    {
        $contact = $this->findContactOrFail($id);

        $this->mapDataToEntity($request->request->all(), $contact);

        $this->domainEventCollector->collect(
            new ContactDataModifiedEvent($contact, $request->request->all())
        );

        $this->entityManager->flush();

        return new JsonResponse($this->getDataForEntity($contact));
    }

    private function findContactOrFail(int $id): Contact
    {
        $contact = $this->entityManager->getRepository(ContactInterface::class)->find($id);

        if (!$contact) {
            throw new NotFoundHttpException();
        }

        if (!$contact instanceof Contact) {
            throw new \RuntimeException(\sprintf('Contact entity is not an instance of %s', Contact::class));
        }

        return $contact;
    }

    /**
     * @return array<string, mixed>
     */
    private function getDataForEntity(Contact $entity): array
    {
        return [
            'id' => $entity->getId(),
            'memberStatus' => $entity->getMemberStatus(),
            'memberSince' => $entity->getMemberSince()?->format('Y-m-d'),
            'activeMember' => $entity->isActiveMember(),
            'membershipSuspended' => $entity->isMembershipSuspended(),
            'membershipSuspendedSince' => $entity->getMembershipSuspendedSince()?->format('Y-m-d'),
            'membershipNotes' => $entity->getMembershipNotes(),
            'memberPrefix' => $entity->getMemberPrefix(),
            'memberSuffix' => $entity->getMemberSuffix(),
            'annotations' => $entity->getAnnotations(),
            'motivation' => $entity->getMotivation(),
            'deceased' => $entity->isDeceased(),
            'deceasedDate' => $entity->getDeceasedDate()?->format('Y-m-d'),
            'displayType' => $entity->getDisplayType(),
        ];
    }

    /**
     * @param array<string, mixed> $data
     */
    private function mapDataToEntity(array $data, Contact $entity): void
    {
        if (\array_key_exists('memberStatus', $data)) {
            $entity->setMemberStatus($data['memberStatus']);
        }

        if (\array_key_exists('activeMember', $data)) {
            $entity->setActiveMember((bool) $data['activeMember']);
        }

        if (\array_key_exists('memberSince', $data)) {
            $entity->setMemberSince(
                $data['memberSince'] ? new \DateTimeImmutable($data['memberSince']) : null
            );
        }

        if (\array_key_exists('membershipSuspended', $data)) {
            $entity->setMembershipSuspended((bool) $data['membershipSuspended']);
        }

        if (\array_key_exists('membershipSuspendedSince', $data)) {
            $entity->setMembershipSuspendedSince(
                $data['membershipSuspendedSince'] ? new \DateTimeImmutable($data['membershipSuspendedSince']) : null
            );
        }

        if (\array_key_exists('membershipNotes', $data)) {
            $entity->setMembershipNotes($data['membershipNotes']);
        }

        if (\array_key_exists('memberPrefix', $data)) {
            $entity->setMemberPrefix($data['memberPrefix']);
        }

        if (\array_key_exists('memberSuffix', $data)) {
            $entity->setMemberSuffix($data['memberSuffix']);
        }

        if (\array_key_exists('annotations', $data)) {
            $entity->setAnnotations($data['annotations']);
        }

        if (\array_key_exists('motivation', $data)) {
            $entity->setMotivation($data['motivation']);
        }

        if (\array_key_exists('deceased', $data)) {
            $entity->setDeceased((bool) $data['deceased']);
        }

        if (\array_key_exists('deceasedDate', $data)) {
            $entity->setDeceasedDate(
                $data['deceasedDate'] ? new \DateTimeImmutable($data['deceasedDate']) : null
            );
        }

        if (\array_key_exists('displayType', $data)) {
            $entity->setDisplayType($data['displayType'] !== null ? (int) $data['displayType'] : null);
        }
    }

    public function getSecurityContext(): string
    {
        return ContactAdmin::CONTACT_SECURITY_CONTEXT;
    }
}
