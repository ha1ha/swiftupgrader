<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Interface for the EventDispatcher which handles the event dispatching layer.
 *
 * @author Chris Corbyn
 */
interface SwiftUpgrade_Events_EventDispatcher
{
    /**
     * Create a new SendEvent for $source and $message.
     *
     * @param SwiftUpgrade_Transport $source
     * @param SwiftUpgrade_Mime_Message
     *
     * @return SwiftUpgrade_Events_SendEvent
     */
    public function createSendEvent(SwiftUpgrade_Transport $source, SwiftUpgrade_Mime_Message $message);

    /**
     * Create a new CommandEvent for $source and $command.
     *
     * @param SwiftUpgrade_Transport $source
     * @param string          $command      That will be executed
     * @param array           $successCodes That are needed
     *
     * @return SwiftUpgrade_Events_CommandEvent
     */
    public function createCommandEvent(SwiftUpgrade_Transport $source, $command, $successCodes = array());

    /**
     * Create a new ResponseEvent for $source and $response.
     *
     * @param SwiftUpgrade_Transport $source
     * @param string          $response
     * @param bool            $valid    If the response is valid
     *
     * @return SwiftUpgrade_Events_ResponseEvent
     */
    public function createResponseEvent(SwiftUpgrade_Transport $source, $response, $valid);

    /**
     * Create a new TransportChangeEvent for $source.
     *
     * @param SwiftUpgrade_Transport $source
     *
     * @return SwiftUpgrade_Events_TransportChangeEvent
     */
    public function createTransportChangeEvent(SwiftUpgrade_Transport $source);

    /**
     * Create a new TransportExceptionEvent for $source.
     *
     * @param SwiftUpgrade_Transport          $source
     * @param SwiftUpgrade_TransportException $ex
     *
     * @return SwiftUpgrade_Events_TransportExceptionEvent
     */
    public function createTransportExceptionEvent(SwiftUpgrade_Transport $source, SwiftUpgrade_TransportException $ex);

    /**
     * Bind an event listener to this dispatcher.
     *
     * @param SwiftUpgrade_Events_EventListener $listener
     */
    public function bindEventListener(SwiftUpgrade_Events_EventListener $listener);

    /**
     * Dispatch the given Event to all suitable listeners.
     *
     * @param SwiftUpgrade_Events_EventObject $evt
     * @param string                   $target method
     */
    public function dispatchEvent(SwiftUpgrade_Events_EventObject $evt, $target);
}
