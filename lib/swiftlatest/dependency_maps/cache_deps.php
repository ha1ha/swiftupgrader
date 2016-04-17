<?php

SwiftUpgrade_DependencyContainer::getInstance()
    ->register('cache')
    ->asAliasOf('cache.array')

    ->register('tempdir')
    ->asValue('/tmp')

    ->register('cache.null')
    ->asSharedInstanceOf('SwiftUpgrade_KeyCache_NullKeyCache')

    ->register('cache.array')
    ->asSharedInstanceOf('SwiftUpgrade_KeyCache_ArrayKeyCache')
    ->withDependencies(array('cache.inputstream'))

    ->register('cache.disk')
    ->asSharedInstanceOf('SwiftUpgrade_KeyCache_DiskKeyCache')
    ->withDependencies(array('cache.inputstream', 'tempdir'))

    ->register('cache.inputstream')
    ->asNewInstanceOf('SwiftUpgrade_KeyCache_SimpleKeyCacheInputStream')
;
