<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2009 Fabien Potencier <fabien.potencier@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Stores Messages in a queue.
 *
 * @author Fabien Potencier
 */
class SwiftUpgrade_Transport_SpoolTransport implements SwiftUpgrade_Transport
{
    /** The spool instance */
    private $_spool;

    /** The event dispatcher from the plugin API */
    private $_eventDispatcher;

    /**
     * Constructor.
     */
    public function __construct(SwiftUpgrade_Events_EventDispatcher $eventDispatcher, SwiftUpgrade_Spool $spool = null)
    {
        $this->_eventDispatcher = $eventDispatcher;
        $this->_spool = $spool;
    }

    /**
     * Sets the spool object.
     *
     * @param SwiftUpgrade_Spool $spool
     *
     * @return SwiftUpgrade_Transport_SpoolTransport
     */
    public function setSpool(SwiftUpgrade_Spool $spool)
    {
        $this->_spool = $spool;

        return $this;
    }

    /**
     * Get the spool object.
     *
     * @return SwiftUpgrade_Spool
     */
    public function getSpool()
    {
        return $this->_spool;
    }

    /**
     * Tests if this Transport mechanism has started.
     *
     * @return bool
     */
    public function isStarted()
    {
        return true;
    }

    /**
     * Starts this Transport mechanism.
     */
    public function start()
    {
    }

    /**
     * Stops this Transport mechanism.
     */
    public function stop()
    {
    }

    /**
     * Sends the given message.
     *
     * @param SwiftUpgrade_Mime_Message $message
     * @param string[]           $failedRecipients An array of failures by-reference
     *
     * @return int The number of sent e-mail's
     */
    public function send(SwiftUpgrade_Mime_Message $message, &$failedRecipients = null)
    {
        if ($evt = $this->_eventDispatcher->createSendEvent($this, $message)) {
            $this->_eventDispatcher->dispatchEvent($evt, 'beforeSendPerformed');
            if ($evt->bubbleCancelled()) {
                return 0;
            }
        }

        $success = $this->_spool->queueMessage($message);

        if ($evt) {
            $evt->setResult($success ? SwiftUpgrade_Events_SendEvent::RESULT_SPOOLED : SwiftUpgrade_Events_SendEvent::RESULT_FAILED);
            $this->_eventDispatcher->dispatchEvent($evt, 'sendPerformed');
        }

        return 1;
    }

    /**
     * Register a plugin.
     *
     * @param SwiftUpgrade_Events_EventListener $plugin
     */
    public function registerPlugin(SwiftUpgrade_Events_EventListener $plugin)
    {
        $this->_eventDispatcher->bindEventListener($plugin);
    }
}
