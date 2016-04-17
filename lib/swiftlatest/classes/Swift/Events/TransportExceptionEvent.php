<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Generated when a TransportException is thrown from the Transport system.
 *
 * @author Chris Corbyn
 */
class SwiftUpgrade_Events_TransportExceptionEvent extends SwiftUpgrade_Events_EventObject
{
    /**
     * The Exception thrown.
     *
     * @var SwiftUpgrade_TransportException
     */
    private $_exception;

    /**
     * Create a new TransportExceptionEvent for $transport.
     *
     * @param SwiftUpgrade_Transport          $transport
     * @param SwiftUpgrade_TransportException $ex
     */
    public function __construct(SwiftUpgrade_Transport $transport, SwiftUpgrade_TransportException $ex)
    {
        parent::__construct($transport);
        $this->_exception = $ex;
    }

    /**
     * Get the TransportException thrown.
     *
     * @return SwiftUpgrade_TransportException
     */
    public function getException()
    {
        return $this->_exception;
    }
}
