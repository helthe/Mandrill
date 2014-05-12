<?php

/*
 * This file is part of the Helthe Mandrill package.
 *
 * (c) Carl Alexander <carlalexander@helthe.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Helthe\Component\Mandrill\Mailer;

/**
 * Basic implementation of a Mandrill mailer that sends text emails.
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */
class Mailer extends AbstractMailer
{
    /**
     * Send a transactional message.
     *
     * @param mixed  $recipients
     * @param mixed  $sender
     * @param string $subject
     * @param string $content
     */
    public function sendMessage($recipients, $sender, $subject, $content)
    {
        $this->client->sendMessage($this->createMessage($recipients, $sender, $subject, $content));
    }
}
