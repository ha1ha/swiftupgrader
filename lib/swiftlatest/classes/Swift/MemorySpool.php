<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2011 Fabien Potencier <fabien.potencier@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Stores Messages in memory.
 *
 * @author Fabien Potencier
 */
class SwiftUpgrade_MemorySpool implements SwiftUpgrade_Spool
{
    protected $messages = array();

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
     * Stores a message in the queue.
     *
     * @param SwiftUpgrade_Mime_Message $message The message to store
     *
     * @return bool Whether the operation has succeeded
     */
    public function queueMessage(SwiftUpgrade_Mime_Message $message)
    {
        //clone the message to make sure it is not changed while in the queue
        $this->messages[] = clone $message;

        return true;
    }

    /**
     * Sends messages using the given transport instance.
     *
     * @param SwiftUpgrade_Transport $transport        A transport instance
     * @param string[]        $failedRecipients An array of failures by-reference
     *
     * @return int The number of sent emails
     */
    public function flushQueue(SwiftUpgrade_Transport $transport, &$failedRecipients = null)
    {
        if (!$this->messages) {
            return 0;
        }

        if (!$transport->isStarted()) {
            $transport->start();
        }

        $count = 0;
        while ($message = array_pop($this->messages)) {
            $count += $transport->send($message, $failedRecipients);
        }

        return $count;
    }
}
