<?php

declare(strict_types=1);

namespace Manuxi\SuluAssociationContactBundle\Admin;

use Manuxi\SuluAppSettingsBasicBundle\Entity\AppSettingsBasic;
use Manuxi\SuluAssociationContactBundle\Entity\AssociationContactSettings;
use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Admin\View\ToolbarAction;
use Sulu\Bundle\AdminBundle\Admin\View\ViewBuilderFactoryInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ViewCollection;
use Sulu\Component\Security\Authorization\PermissionTypes;
use Sulu\Component\Security\Authorization\SecurityCheckerInterface;

class AssociationContactSettingsAdmin extends Admin
{

    public const TAB_VIEW = 'app.association_contact_settings';
    public const FORM_VIEW = 'app.association_contact_settings.form';

    private ViewBuilderFactoryInterface $viewBuilderFactory;
    private SecurityCheckerInterface $securityChecker;

    public function __construct(
        ViewBuilderFactoryInterface $viewBuilderFactory,
        SecurityCheckerInterface $securityChecker
    ) {
        $this->viewBuilderFactory = $viewBuilderFactory;
        $this->securityChecker = $securityChecker;
    }

    public function configureViews(ViewCollection $viewCollection): void
    {
        if ($viewCollection->has("app.app_settings_basic.form")) {
            $appSettingsBasicFormView = $viewCollection->get("app.app_settings_basic.form")->getView();

            if ($this->securityChecker->hasPermission(AssociationContactSettings::SECURITY_CONTEXT, PermissionTypes::EDIT)) {

/*                $viewCollection->add(
                // sulu will only load the existing entity if the path of the form includes an id attribute
                    $this->viewBuilderFactory->createResourceTabViewBuilder(static::TAB_VIEW, '/app-settings/:id')
                        ->setResourceKey(AssociationContactSettings::RESOURCE_KEY)
                        ->setAttributeDefault('id', '-')
                );*/

                $viewCollection->add(
                    $this->viewBuilderFactory
                        ->createFormViewBuilder(static::FORM_VIEW, '/members')
                        ->setResourceKey(AssociationContactSettings::RESOURCE_KEY)
                        ->setFormKey(AssociationContactSettings::FORM_KEY)
                        ->setTabTitle('association_contact.settings.title.tab')
                        ->addToolbarActions([new ToolbarAction('sulu_admin.save')])
                        ->setTabOrder($appSettingsBasicFormView->getOption('tabOrder') + 1)
                        ->setParent("app.app_settings_basic")
                );
            }
        }
    }

    /**
     * @return mixed[]
     */
    public function getSecurityContexts(): array
    {
        return [
            self::SULU_ADMIN_SECURITY_SYSTEM => [
                'Settings' => [
                    AssociationContactSettings::SECURITY_CONTEXT => [
                        PermissionTypes::VIEW,
                        PermissionTypes::EDIT,
                    ],
                ],
            ],
        ];
    }
}