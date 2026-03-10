<?php

declare(strict_types=1);

namespace Manuxi\SuluAssociationContactBundle\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\View\ViewHandlerInterface;
use Manuxi\SuluAssociationContactBundle\Entity\AssociationContactSettings;
use Sulu\Component\Rest\AbstractRestController;
use Sulu\Component\Security\SecuredControllerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/admin/api')]
class AssociationContactSettingsController extends AbstractRestController implements SecuredControllerInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        ViewHandlerInterface $viewHandler,
        ?TokenStorageInterface $tokenStorage = null,
    ) {
        parent::__construct($viewHandler, $tokenStorage);
    }

    #[Route(
        '/association-contact-settings/{id}',
        name: 'sulu_association_contact.get_settings',
        defaults: ['id' => '-'],
        methods: ['GET'],
    )]
    public function getAction(): Response
    {
        $entity = $this->entityManager
            ->getRepository(AssociationContactSettings::class)
            ->findOneBy([]);

        return new JsonResponse($this->getDataForEntity($entity ?: new AssociationContactSettings()));
    }

    #[Route(
        '/association-contact-settings/{id}',
        name: 'sulu_association_contact.put_settings',
        defaults: ['id' => '-'],
        methods: ['PUT'],
    )]
    public function putAction(Request $request): Response
    {
        $entity = $this->entityManager
            ->getRepository(AssociationContactSettings::class)
            ->findOneBy([]);

        if (!$entity) {
            $entity = new AssociationContactSettings();
            $this->entityManager->persist($entity);
        }

        $data = $request->toArray();
        $this->mapDataToEntity($data, $entity);
        $this->entityManager->flush();

        return new JsonResponse($this->getDataForEntity($entity));
    }

    /**
     * @return array<string, mixed>
     */
    private function getDataForEntity(AssociationContactSettings $entity): array
    {
        return [
            'id' => $entity->getId() ?? '-',
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

    /**
     * @param array<string, mixed> $data
     */
    private function mapDataToEntity(array $data, AssociationContactSettings $entity): void
    {
        if (\array_key_exists('toggleHeader', $data)) {
            $entity->setToggleHeader($data['toggleHeader']);
        }

        if (\array_key_exists('toggleHero', $data)) {
            $entity->setToggleHero($data['toggleHero']);
        }

        if (\array_key_exists('toggleBreadcrumbs', $data)) {
            $entity->setToggleBreadcrumbs($data['toggleBreadcrumbs']);
        }

        if (\array_key_exists('pageMembers', $data)) {
            $entity->setPageMembers($data['pageMembers']);
        }

        if (\array_key_exists('pageMembersActive', $data)) {
            $entity->setPageMembersActive($data['pageMembersActive']);
        }

        if (\array_key_exists('pageMembersPassive', $data)) {
            $entity->setPageMembersPassive($data['pageMembersPassive']);
        }

        if (\array_key_exists('pageMembersHonorary', $data)) {
            $entity->setPageMembersHonorary($data['pageMembersHonorary']);
        }

        if (\array_key_exists('pageMembersSupporting', $data)) {
            $entity->setPageMembersSupporting($data['pageMembersSupporting']);
        }

        if (\array_key_exists('pageMembersFounding', $data)) {
            $entity->setPageMembersFounding($data['pageMembersFounding']);
        }

        if (\array_key_exists('pageMembersYouth', $data)) {
            $entity->setPageMembersYouth($data['pageMembersYouth']);
        }

        if (\array_key_exists('pageMembersBoard', $data)) {
            $entity->setPageMembersBoard($data['pageMembersBoard']);
        }

        if (\array_key_exists('pageMembersProbationary', $data)) {
            $entity->setPageMembersProbationary($data['pageMembersProbationary']);
        }

        if (\array_key_exists('pageMembersExternal', $data)) {
            $entity->setPageMembersExternal($data['pageMembersExternal']);
        }

        if (\array_key_exists('pageMembersDormant', $data)) {
            $entity->setPageMembersDormant($data['pageMembersDormant']);
        }

        if (\array_key_exists('pageMembersGuest', $data)) {
            $entity->setPageMembersGuest($data['pageMembersGuest']);
        }
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
