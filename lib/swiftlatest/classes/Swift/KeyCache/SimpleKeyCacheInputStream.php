<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Writes data to a KeyCache using a stream.
 *
 * @author Chris Corbyn
 */
class SwiftUpgrade_KeyCache_SimpleKeyCacheInputStream implements SwiftUpgrade_KeyCache_KeyCacheInputStream
{
    /** The KeyCache being written to */
    private $_keyCache;

    /** The nsKey of the KeyCache being written to */
    private $_nsKey;

    /** The itemKey of the KeyCache being written to */
    private $_itemKey;

    /** A stream to write through on each write() */
    private $_writeThrough = null;

    /**
     * Set the KeyCache to wrap.
     *
     * @param SwiftUpgrade_KeyCache $keyCache
     */
    public function setKeyCache(SwiftUpgrade_KeyCache $keyCache)
    {
        $this->_keyCache = $keyCache;
    }

    /**
     * Specify a stream to write through for each write().
     *
     * @param SwiftUpgrade_InputByteStream $is
     */
    public function setWriteThroughStream(SwiftUpgrade_InputByteStream $is)
    {
        $this->_writeThrough = $is;
    }

    /**
     * Writes $bytes to the end of the stream.
     *
     * @param string                $bytes
     * @param SwiftUpgrade_InputByteStream $is    optional
     */
    public function write($bytes, SwiftUpgrade_InputByteStream $is = null)
    {
        $this->_keyCache->setString(
            $this->_nsKey, $this->_itemKey, $bytes, SwiftUpgrade_KeyCache::MODE_APPEND
            );
        if (isset($is)) {
            $is->write($bytes);
        }
        if (isset($this->_writeThrough)) {
            $this->_writeThrough->write($bytes);
        }
    }

    /**
     * Not used.
     */
    public function commit()
    {
    }

    /**
     * Not used.
     */
    public function bind(SwiftUpgrade_InputByteStream $is)
    {
    }

    /**
     * Not used.
     */
    public function unbind(SwiftUpgrade_InputByteStream $is)
    {
    }

    /**
     * Flush the contents of the stream (empty it) and set the internal pointer
     * to the beginning.
     */
    public function flushBuffers()
    {
        $this->_keyCache->clearKey($this->_nsKey, $this->_itemKey);
    }

    /**
     * Set the nsKey which will be written to.
     *
     * @param string $nsKey
     */
    public function setNsKey($nsKey)
    {
        $this->_nsKey = $nsKey;
    }

    /**
     * Set the itemKey which will be written to.
     *
     * @param string $itemKey
     */
    public function setItemKey($itemKey)
    {
        $this->_itemKey = $itemKey;
    }

    /**
     * Any implementation should be cloneable, allowing the clone to access a
     * separate $nsKey and $itemKey.
     */
    public function __clone()
    {
        $this->_writeThrough = null;
    }
}
