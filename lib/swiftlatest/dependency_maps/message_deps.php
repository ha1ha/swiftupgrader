<?php

SwiftUpgrade_DependencyContainer::getInstance()
    ->register('message.message')
    ->asNewInstanceOf('SwiftUpgrade_Message')

    ->register('message.mimepart')
    ->asNewInstanceOf('SwiftUpgrade_MimePart')
;
