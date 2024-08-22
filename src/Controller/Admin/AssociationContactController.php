<?php

declare(strict_types=1);

namespace Manuxi\SuluAssociationContactBundle\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\View\ViewHandlerInterface;
use HandcraftedInTheAlps\RestRoutingBundle\Controller\Annotations\RouteResource;
use HandcraftedInTheAlps\RestRoutingBundle\Routing\ClassResourceInterface;
use Manuxi\SuluAssociationContactBundle\Domain\Event\ContactDataModifiedEvent;
use Manuxi\SuluAssociationContactBundle\Entity\Contact;
use Sulu\Bundle\ActivityBundle\Application\Collector\DomainEventCollectorInterface;
use Sulu\Bundle\ContactBundle\Admin\ContactAdmin;
use Sulu\Component\Rest\AbstractRestController;
use Sulu\Component\Security\SecuredControllerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @RouteResource("association-contact")
 */
class AssociationContactController extends AbstractRestController implements ClassResourceInterface, SecuredControllerInterface
{
    private EntityManagerInterface $entityManager;
    private DomainEventCollectorInterface $domainEventCollector;

    public function __construct(
        EntityManagerInterface $entityManager,
        ViewHandlerInterface $viewHandler,
        DomainEventCollectorInterface $domainEventCollector,
        ?TokenStorageInterface $tokenStorage = null
    ) {
        parent::__construct($viewHandler, $tokenStorage);
        $this->entityManager = $entityManager;
        $this->domainEventCollector = $domainEventCollector;
    }

    public function getAction(int $id): Response
    {
        $contact = $this->entityManager->getRepository(Contact::class)->find($id);
        if (!$contact) {
            throw new NotFoundHttpException();
        }

        return $this->handleView($this->view($this->getDataForEntity($contact)));
    }

    public function putAction(Request $request, int $id): Response
    {
        $contact = $this->entityManager->getRepository(Contact::class)->find($id);
        if (!$contact) {
            throw new NotFoundHttpException();
        }

        $this->mapDataToEntity($request->request->all(), $contact);

        $this->domainEventCollector->collect(
            new ContactDataModifiedEvent($contact, $request->request->all())
        );

        $this->entityManager->persist($contact);
        $this->entityManager->flush();

        return $this->handleView($this->view($this->getDataForEntity($contact)));
    }

    /**
     * @return array<string, mixed>
     */
    protected function getDataForEntity(Contact $entity): array
    {
        return [
            'id' => $entity->getId(),
            'memberStatus' => $entity->getMemberStatus(),
            'memberSince' => $entity->getMemberSince(),
            'activeMember' => $entity->isActiveMember(),
            'membershipSuspended' => $entity->isMembershipSuspended(),
            'membershipSuspendedSince' => $entity->getMembershipSuspendedSince(),
            'membershipNotes' => $entity->getMembershipNotes(),
            'memberPrefix' => $entity->getMemberPrefix(),
            'memberSuffix' => $entity->getMemberSuffix(),
            'annotations' => $entity->getAnnotations(),
            'motivation' => $entity->getMotivation(),
            'deceased' => $entity->isDeceased(),
            'deceasedDate' => $entity->getDeceasedDate(),
            'displayType' => $entity->getDisplayType()
        ];
    }

    /**
     * @param array<string, mixed> $data
     */
    protected function mapDataToEntity(array $data, Contact $entity): void
    {

        $entity->setMemberStatus($data['memberStatus']);
        $entity->setActiveMember($data['activeMember']);

        $memberSince = $data['memberSince'] ? new \DateTimeImmutable($data['memberSince']) : null;
        $entity->setMemberSince($memberSince);

        $entity->setMembershipSuspended($data['membershipSuspended']);

        $membershipSuspendedSince = $data['membershipSuspendedSince'] ? new \DateTimeImmutable($data['membershipSuspendedSince']) : null;
        $entity->setMembershipSuspendedSince($membershipSuspendedSince);

        $entity->setMembershipNotes($data['membershipNotes']);
        $entity->setMemberPrefix($data['memberPrefix']);
        $entity->setMemberSuffix($data['memberSuffix']);

        $entity->setAnnotations($data['annotations']);
        $entity->setMotivation($data['motivation']);
        $entity->setDeceased($data['deceased']);

        $deceasedDate = $data['deceasedDate'] ? new \DateTimeImmutable($data['deceasedDate']) : null;
        $entity->setDeceasedDate($deceasedDate);

        $entity->setDisplayType($data['displayType']);
    }

    public function getSecurityContext(): string
    {
        return ContactAdmin::CONTACT_SECURITY_CONTEXT;
    }
}