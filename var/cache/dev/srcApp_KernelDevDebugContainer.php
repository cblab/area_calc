<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerLxot2MX\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerLxot2MX/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerLxot2MX.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerLxot2MX\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerLxot2MX\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'Lxot2MX',
    'container.build_id' => '92bc03cb',
    'container.build_time' => 1567622659,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerLxot2MX');
