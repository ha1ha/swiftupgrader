<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Handles raw Transfer Encoding in Swift Mailer.
 *
 *
 * @author Sebastiaan Stok <s.stok@rollerscapes.net>
 */
class SwiftUpgrade_Mime_ContentEncoder_RawContentEncoder implements SwiftUpgrade_Mime_ContentEncoder
{
    /**
     * Encode a given string to produce an encoded string.
     *
     * @param string $string
     * @param int    $firstLineOffset ignored
     * @param int    $maxLineLength   ignored
     *
     * @return string
     */
    public function encodeString($string, $firstLineOffset = 0, $maxLineLength = 0)
    {
        return $string;
    }

    /**
     * Encode stream $in to stream $out.
     *
     * @param SwiftUpgrade_OutputByteStream $in
     * @param SwiftUpgrade_InputByteStream  $out
     * @param int                    $firstLineOffset ignored
     * @param int                    $maxLineLength   ignored
     */
    public function encodeByteStream(SwiftUpgrade_OutputByteStream $os, SwiftUpgrade_InputByteStream $is, $firstLineOffset = 0, $maxLineLength = 0)
    {
        while (false !== ($bytes = $os->read(8192))) {
            $is->write($bytes);
        }
    }

    /**
     * Get the name of this encoding scheme.
     *
     * @return string
     */
    public function getName()
    {
        return 'raw';
    }

    /**
     * Not used.
     */
    public function charsetChanged($charset)
    {
    }
}
