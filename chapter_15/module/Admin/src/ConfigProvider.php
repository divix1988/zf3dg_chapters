<?php

namespace Admin;

class ConfigProvider
{

    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
            'view_manager' => $this->getViewManagerConfig(),
            'admin' => $this->getModuleConfig(),
        ];
    }

    public function getDependencyConfig()
    {
        return [
            'factories' => [
                'admin_navigation' => Navigation\Service\AdminNavigationFactory::class,
            ],
        ];
    }

    public function getViewManagerConfig()
    {
        return [
            'template_path_stack' => [
                __DIR__ . '/../view',
            ],
        ];
    }

    public function getModuleConfig()
    {
        return [
            'use_admin_layout' => true,
            'admin_layout_template' => 'layout/admin',
        ];
    }
}