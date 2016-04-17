<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * The EventDispatcher which handles the event dispatching layer.
 *
 * @author Chris Corbyn
 */
class SwiftUpgrade_Events_SimpleEventDispatcher implements SwiftUpgrade_Events_EventDispatcher
{
    /** A map of event types to their associated listener types */
    private $_eventMap = array();

    /** Event listeners bound to this dispatcher */
    private $_listeners = array();

    /** Listeners queued to have an Event bubbled up the stack to them */
    private $_bubbleQueue = array();

    /**
     * Create a new EventDispatcher.
     */
    public function __construct()
    {
        $this->_eventMap = array(
            'SwiftUpgrade_Events_CommandEvent' => 'SwiftUpgrade_Events_CommandListener',
            'SwiftUpgrade_Events_ResponseEvent' => 'SwiftUpgrade_Events_ResponseListener',
            'SwiftUpgrade_Events_SendEvent' => 'SwiftUpgrade_Events_SendListener',
            'SwiftUpgrade_Events_TransportChangeEvent' => 'SwiftUpgrade_Events_TransportChangeListener',
            'SwiftUpgrade_Events_TransportExceptionEvent' => 'SwiftUpgrade_Events_TransportExceptionListener',
            );
    }

    /**
     * Create a new SendEvent for $source and $message.
     *
     * @param SwiftUpgrade_Transport $source
     * @param SwiftUpgrade_Mime_Message
     *
     * @return SwiftUpgrade_Events_SendEvent
     */
    public function createSendEvent(SwiftUpgrade_Transport $source, SwiftUpgrade_Mime_Message $message)
    {
        return new SwiftUpgrade_Events_SendEvent($source, $message);
    }

    /**
     * Create a new CommandEvent for $source and $command.
     *
     * @param SwiftUpgrade_Transport $source
     * @param string          $command      That will be executed
     * @param array           $successCodes That are needed
     *
     * @return SwiftUpgrade_Events_CommandEvent
     */
    public function createCommandEvent(SwiftUpgrade_Transport $source, $command, $successCodes = array())
    {
        return new SwiftUpgrade_Events_CommandEvent($source, $command, $successCodes);
    }

    /**
     * Create a new ResponseEvent for $source and $response.
     *
     * @param SwiftUpgrade_Transport $source
     * @param string          $response
     * @param bool            $valid    If the response is valid
     *
     * @return SwiftUpgrade_Events_ResponseEvent
     */
    public function createResponseEvent(SwiftUpgrade_Transport $source, $response, $valid)
    {
        return new SwiftUpgrade_Events_ResponseEvent($source, $response, $valid);
    }

    /**
     * Create a new TransportChangeEvent for $source.
     *
     * @param SwiftUpgrade_Transport $source
     *
     * @return SwiftUpgrade_Events_TransportChangeEvent
     */
    public function createTransportChangeEvent(SwiftUpgrade_Transport $source)
    {
        return new SwiftUpgrade_Events_TransportChangeEvent($source);
    }

    /**
     * Create a new TransportExceptionEvent for $source.
     *
     * @param SwiftUpgrade_Transport          $source
     * @param SwiftUpgrade_TransportException $ex
     *
     * @return SwiftUpgrade_Events_TransportExceptionEvent
     */
    public function createTransportExceptionEvent(SwiftUpgrade_Transport $source, SwiftUpgrade_TransportException $ex)
    {
        return new SwiftUpgrade_Events_TransportExceptionEvent($source, $ex);
    }

    /**
     * Bind an event listener to this dispatcher.
     *
     * @param SwiftUpgrade_Events_EventListener $listener
     */
    public function bindEventListener(SwiftUpgrade_Events_EventListener $listener)
    {
        foreach ($this->_listeners as $l) {
            // Already loaded
            if ($l === $listener) {
                return;
            }
        }
        $this->_listeners[] = $listener;
    }

    /**
     * Dispatch the given Event to all suitable listeners.
     *
     * @param SwiftUpgrade_Events_EventObject $evt
     * @param string                   $target method
     */
    public function dispatchEvent(SwiftUpgrade_Events_EventObject $evt, $target)
    {
        $this->_prepareBubbleQueue($evt);
        $this->_bubble($evt, $target);
    }

    /** Queue listeners on a stack ready for $evt to be bubbled up it */
    private function _prepareBubbleQueue(SwiftUpgrade_Events_EventObject $evt)
    {
        $this->_bubbleQueue = array();
        $evtClass = get_class($evt);
        foreach ($this->_listeners as $listener) {
            if (array_key_exists($evtClass, $this->_eventMap)
                && ($listener instanceof $this->_eventMap[$evtClass])) {
                $this->_bubbleQueue[] = $listener;
            }
        }
    }

    /** Bubble $evt up the stack calling $target() on each listener */
    private function _bubble(SwiftUpgrade_Events_EventObject $evt, $target)
    {
        if (!$evt->bubbleCancelled() && $listener = array_shift($this->_bubbleQueue)) {
            $listener->$target($evt);
            $this->_bubble($evt, $target);
        }
    }
}
