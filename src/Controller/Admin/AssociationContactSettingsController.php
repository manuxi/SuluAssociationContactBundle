<?php

declare(strict_types=1);

namespace Manuxi\SuluAssociationContactBundle\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\View\ViewHandlerInterface;
use HandcraftedInTheAlps\RestRoutingBundle\Controller\Annotations\RouteResource;
use HandcraftedInTheAlps\RestRoutingBundle\Routing\ClassResourceInterface;
use Manuxi\SuluAssociationContactBundle\Entity\AssociationContactSettings;
use Sulu\Component\Rest\AbstractRestController;
use Sulu\Component\Security\SecuredControllerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @RouteResource("association-contact-settings")
 */
class AssociationContactSettingsController extends AbstractRestController implements ClassResourceInterface, SecuredControllerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        ViewHandlerInterface $viewHandler,
        ?TokenStorageInterface $tokenStorage = null
    ) {
        $this->entityManager = $entityManager;

        parent::__construct($viewHandler, $tokenStorage);
    }

    public function getAction(): Response
    {
        $applicationSettings = $this->entityManager->getRepository(AssociationContactSettings::class)->findOneBy([]);

        return $this->handleView($this->view($this->getDataForEntity($applicationSettings ?: new AssociationContactSettings())));
    }

    public function putAction(Request $request): Response
    {
        $applicationSettings = $this->entityManager->getRepository(AssociationContactSettings::class)->findOneBy([]);
        if (!$applicationSettings) {
            $applicationSettings = new AssociationContactSettings();
            $this->entityManager->persist($applicationSettings);
        }

        $data = $request->toArray();
        $this->mapDataToEntity($data, $applicationSettings);
        $this->entityManager->flush();

        return $this->handleView($this->view($this->getDataForEntity($applicationSettings)));
    }

    protected function getDataForEntity(AssociationContactSettings $entity): array
    {
        return [
            'toggleHeader' => $entity->getToggleHeader(),
            'toggleHero' => $entity->getToggleHero(),
            'toggleBreadcrumbs' => $entity->getToggleBreadcrumbs(),

            'pageMembers' => $entity->getPageMembers(),
            'pageMembersActive' => $entity->getPageMembersActive(),
            'pageMembersPassive' => $entity->getPageMembersPassive(),
            'pageMembersHonorary' => $entity->getPageMembersHonorary(),
            'pageMembersSupporting' => $entity->getPageMembersSupporting(),
            'pageMembersFounding' => $entity->getPageMembersFounding(),
            'pageMembersYouth' => $entity->getPageMembersYouth(),
            'pageMembersBoard' => $entity->getPageMembersBoard(),
            'pageMembersProbationary' => $entity->getPageMembersProbationary(),
            'pageMembersExternal' => $entity->getPageMembersExternal(),
            'pageMembersDormant' => $entity->getPageMembersDormant(),
            'pageMembersGuest' => $entity->getPageMembersGuest(),
        ];
    }

    protected function mapDataToEntity(array $data, AssociationContactSettings $entity): void
    {
        $entity->setToggleHeader($data['toggleHeader']);
        $entity->setToggleHero($data['toggleHero']);
        $entity->setToggleBreadcrumbs($data['toggleBreadcrumbs']);

        $entity->setPageMembers($data['pageMembers']);
        $entity->setPageMembersActive($data['pageMembersActive']);
        $entity->setPageMembersPassive($data['pageMembersPassive']);
        $entity->setPageMembersHonorary($data['pageMembersHonorary']);
        $entity->setPageMembersSupporting($data['pageMembersSupporting']);
        $entity->setPageMembersFounding($data['pageMembersFounding']);
        $entity->setPageMembersYouth($data['pageMembersYouth']);
        $entity->setPageMembersBoard($data['pageMembersBoard']);
        $entity->setPageMembersProbationary($data['pageMembersProbationary']);
        $entity->setPageMembersExternal($data['pageMembersExternal']);
        $entity->setPageMembersDormant($data['pageMembersDormant']);
        $entity->setPageMembersGuest($data['pageMembersGuest']);

    }

    public function getSecurityContext(): string
    {
        return AssociationContactSettings::SECURITY_CONTEXT;
    }

    public function getLocale(Request $request): ?string
    {
        return $request->query->get('locale');
    }
}