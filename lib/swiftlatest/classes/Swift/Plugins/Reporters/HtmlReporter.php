<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A HTML output reporter for the Reporter plugin.
 *
 * @author Chris Corbyn
 */
class SwiftUpgrade_Plugins_Reporters_HtmlReporter implements SwiftUpgrade_Plugins_Reporter
{
    /**
     * Notifies this ReportNotifier that $address failed or succeeded.
     *
     * @param SwiftUpgrade_Mime_Message $message
     * @param string             $address
     * @param int                $result  from {@see RESULT_PASS, RESULT_FAIL}
     */
    public function notify(SwiftUpgrade_Mime_Message $message, $address, $result)
    {
        if (self::RESULT_PASS == $result) {
            echo '<div style="color: #fff; background: #006600; padding: 2px; margin: 2px;">'.PHP_EOL;
            echo 'PASS '.$address.PHP_EOL;
            echo '</div>'.PHP_EOL;
            flush();
        } else {
            echo '<div style="color: #fff; background: #880000; padding: 2px; margin: 2px;">'.PHP_EOL;
            echo 'FAIL '.$address.PHP_EOL;
            echo '</div>'.PHP_EOL;
            flush();
        }
    }
}
