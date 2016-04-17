<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Listens for Messages being sent from within the Transport system.
 *
 * @author Chris Corbyn
 */
interface SwiftUpgrade_Events_SendListener extends SwiftUpgrade_Events_EventListener
{
    /**
     * Invoked immediately before the Message is sent.
     *
     * @param SwiftUpgrade_Events_SendEvent $evt
     */
    public function beforeSendPerformed(SwiftUpgrade_Events_SendEvent $evt);

    /**
     * Invoked immediately after the Message is sent.
     *
     * @param SwiftUpgrade_Events_SendEvent $evt
     */
    public function sendPerformed(SwiftUpgrade_Events_SendEvent $evt);
}
