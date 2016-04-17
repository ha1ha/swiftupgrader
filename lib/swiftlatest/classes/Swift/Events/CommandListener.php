<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Listens for Transports to send commands to the server.
 *
 * @author Chris Corbyn
 */
interface SwiftUpgrade_Events_CommandListener extends SwiftUpgrade_Events_EventListener
{
    /**
     * Invoked immediately following a command being sent.
     *
     * @param SwiftUpgrade_Events_CommandEvent $evt
     */
    public function commandSent(SwiftUpgrade_Events_CommandEvent $evt);
}
