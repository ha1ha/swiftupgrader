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
class SwiftUpgrade_SpoolTransport extends SwiftUpgrade_Transport_SpoolTransport
{
    /**
     * Create a new SpoolTransport.
     *
     * @param SwiftUpgrade_Spool $spool
     */
    public function __construct(SwiftUpgrade_Spool $spool)
    {
        $arguments = SwiftUpgrade_DependencyContainer::getInstance()
            ->createDependenciesFor('transport.spool');

        $arguments[] = $spool;

        call_user_func_array(
            array($this, 'SwiftUpgrade_Transport_SpoolTransport::__construct'),
            $arguments
        );
    }

    /**
     * Create a new SpoolTransport instance.
     *
     * @param SwiftUpgrade_Spool $spool
     *
     * @return SwiftUpgrade_SpoolTransport
     */
    public static function newInstance(SwiftUpgrade_Spool $spool)
    {
        return new self($spool);
    }
}
