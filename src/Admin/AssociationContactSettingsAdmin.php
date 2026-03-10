<?php

declare(strict_types=1);

namespace Manuxi\SuluAssociationContactBundle\Admin;

use Manuxi\SuluAssociationContactBundle\Entity\AssociationContactSettings;
use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItem;
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItemCollection;
use Sulu\Bundle\AdminBundle\Admin\View\ToolbarAction;
use Sulu\Bundle\AdminBundle\Admin\View\ViewBuilderFactoryInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ViewCollection;
use Sulu\Component\Security\Authorization\PermissionTypes;
use Sulu\Component\Security\Authorization\SecurityCheckerInterface;

class AssociationContactSettingsAdmin extends Admin
{
    public const TAB_VIEW = 'app.association_contact_settings';
    public const FORM_VIEW = 'app.association_contact_settings.form';

    public function __construct(
        private readonly ViewBuilderFactoryInterface $viewBuilderFactory,
        private readonly SecurityCheckerInterface $securityChecker,
    ) {
    }

    public function configureNavigationItems(NavigationItemCollection $navigationItemCollection): void
    {
        if (!$this->securityChecker->hasPermission(AssociationContactSettings::SECURITY_CONTEXT, PermissionTypes::EDIT)) {
            return;
        }

        $settingsNavigationItem = $navigationItemCollection->get(Admin::SETTINGS_NAVIGATION_ITEM);

        $navigationItem = new NavigationItem('association_contact.settings.title');
        $navigationItem->setPosition(30);
        $navigationItem->setView(static::TAB_VIEW);

        $settingsNavigationItem?->addChild($navigationItem);
    }

    public function configureViews(ViewCollection $viewCollection): void
    {
        if (!$this->securityChecker->hasPermission(AssociationContactSettings::SECURITY_CONTEXT, PermissionTypes::EDIT)) {
            return;
        }

        $viewCollection->add(
            $this->viewBuilderFactory
                ->createResourceTabViewBuilder(static::TAB_VIEW, '/association-contact-settings/:id')
                ->setResourceKey(AssociationContactSettings::RESOURCE_KEY)
                ->setAttributeDefault('id', '-')
        );

        $viewCollection->add(
            $this->viewBuilderFactory
                ->createFormViewBuilder(static::FORM_VIEW, '/details')
                ->setResourceKey(AssociationContactSettings::RESOURCE_KEY)
                ->setFormKey(AssociationContactSettings::FORM_KEY)
                ->setTabTitle('association_contact.settings.title')
                ->addToolbarActions([new ToolbarAction('sulu_admin.save')])
                ->setParent(static::TAB_VIEW)
        );
    }

    public function getSecurityContexts(): array
    {
        return [
            self::SULU_ADMIN_SECURITY_SYSTEM => [
                'Settings' => [
                    AssociationContactSettings::SECURITY_CONTEXT => [
                        PermissionTypes::EDIT,
                    ],
                ],
            ],
        ];
    }
}
