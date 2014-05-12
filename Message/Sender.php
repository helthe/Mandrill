<?php

/*
 * This file is part of the Helthe Mandrill package.
 *
 * (c) Carl Alexander <carlalexander@helthe.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Helthe\Component\Mandrill\Message;

/**
 * Sender of the transactional message.
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */
class Sender
{
    /**
     * Sender's email address.
     *
     * @var string
     */
    private $email;

    /**
     * Display name of the sender.
     *
     * @var string
     */
    private $name;

    /**
     * Constructor.
     *
     * @param string $email
     * @param string $name
     */
    public function __construct($email, $name = '')
    {
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * Get the sender's email address.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the display name of the sender.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
