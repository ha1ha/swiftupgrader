<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Handles LOGIN authentication.
 *
 * @author Chris Corbyn
 */
class SwiftUpgrade_Transport_Esmtp_Auth_LoginAuthenticator implements SwiftUpgrade_Transport_Esmtp_Authenticator
{
    /**
     * Get the name of the AUTH mechanism this Authenticator handles.
     *
     * @return string
     */
    public function getAuthKeyword()
    {
        return 'LOGIN';
    }

    /**
     * Try to authenticate the user with $username and $password.
     *
     * @param SwiftUpgrade_Transport_SmtpAgent $agent
     * @param string                    $username
     * @param string                    $password
     *
     * @return bool
     */
    public function authenticate(SwiftUpgrade_Transport_SmtpAgent $agent, $username, $password)
    {
        try {
            $agent->executeCommand("AUTH LOGIN\r\n", array(334));
            $agent->executeCommand(sprintf("%s\r\n", base64_encode($username)), array(334));
            $agent->executeCommand(sprintf("%s\r\n", base64_encode($password)), array(235));

            return true;
        } catch (SwiftUpgrade_TransportException $e) {
            $agent->executeCommand("RSET\r\n", array(250));

            return false;
        }
    }
}