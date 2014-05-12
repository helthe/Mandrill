<?php

/*
 * This file is part of the Helthe Mandrill package.
 *
 * (c) Carl Alexander <carlalexander@helthe.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Helthe\Component\Mandrill;

use Helthe\Component\Mandrill\Message\Message;

/**
 * Interface for interacting with the Mandrill API.
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */
interface ClientInterface
{
    /**
     * Mandrill API base URL.
     */
    const BASE_URL = 'https://mandrillapp.com/api/1.0';

    /**
     * Client version.
     */
    const VERSION = '0.1.0';

    /**
     * Sends a new transactional message.
     *
     * @param Message $message
     */
    public function sendMessage(Message $message);
}
