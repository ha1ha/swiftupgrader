<?php

SwiftUpgrade_DependencyContainer::getInstance()
    ->register('transport.smtp')
    ->asNewInstanceOf('SwiftUpgrade_Transport_EsmtpTransport')
    ->withDependencies(array(
        'transport.buffer',
        array('transport.authhandler'),
        'transport.eventdispatcher',
    ))

    ->register('transport.sendmail')
    ->asNewInstanceOf('SwiftUpgrade_Transport_SendmailTransport')
    ->withDependencies(array(
        'transport.buffer',
        'transport.eventdispatcher',
    ))

    ->register('transport.mail')
    ->asNewInstanceOf('SwiftUpgrade_Transport_MailTransport')
    ->withDependencies(array('transport.mailinvoker', 'transport.eventdispatcher'))

    ->register('transport.loadbalanced')
    ->asNewInstanceOf('SwiftUpgrade_Transport_LoadBalancedTransport')

    ->register('transport.failover')
    ->asNewInstanceOf('SwiftUpgrade_Transport_FailoverTransport')

    ->register('transport.spool')
    ->asNewInstanceOf('SwiftUpgrade_Transport_SpoolTransport')
    ->withDependencies(array('transport.eventdispatcher'))

    ->register('transport.null')
    ->asNewInstanceOf('SwiftUpgrade_Transport_NullTransport')
    ->withDependencies(array('transport.eventdispatcher'))

    ->register('transport.mailinvoker')
    ->asSharedInstanceOf('SwiftUpgrade_Transport_SimpleMailInvoker')

    ->register('transport.buffer')
    ->asNewInstanceOf('SwiftUpgrade_Transport_StreamBuffer')
    ->withDependencies(array('transport.replacementfactory'))

    ->register('transport.authhandler')
    ->asNewInstanceOf('SwiftUpgrade_Transport_Esmtp_AuthHandler')
    ->withDependencies(array(
        array(
            'transport.crammd5auth',
            'transport.loginauth',
            'transport.plainauth',
            'transport.ntlmauth',
            'transport.xoauth2auth',
        ),
    ))

    ->register('transport.crammd5auth')
    ->asNewInstanceOf('SwiftUpgrade_Transport_Esmtp_Auth_CramMd5Authenticator')

    ->register('transport.loginauth')
    ->asNewInstanceOf('SwiftUpgrade_Transport_Esmtp_Auth_LoginAuthenticator')

    ->register('transport.plainauth')
    ->asNewInstanceOf('SwiftUpgrade_Transport_Esmtp_Auth_PlainAuthenticator')

    ->register('transport.xoauth2auth')
    ->asNewInstanceOf('SwiftUpgrade_Transport_Esmtp_Auth_XOAuth2Authenticator')

    ->register('transport.ntlmauth')
    ->asNewInstanceOf('SwiftUpgrade_Transport_Esmtp_Auth_NTLMAuthenticator')

    ->register('transport.eventdispatcher')
    ->asNewInstanceOf('SwiftUpgrade_Events_SimpleEventDispatcher')

    ->register('transport.replacementfactory')
    ->asSharedInstanceOf('SwiftUpgrade_StreamFilters_StringReplacementFilterFactory')
;
