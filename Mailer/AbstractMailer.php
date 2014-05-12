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

use Helthe\Component\Mandrill\ClientInterface;
use Helthe\Component\Mandrill\Message\Message;
use Helthe\Component\Mandrill\Message\Sender;

/**
 * Base class for Mandrill mailers.
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */
abstract class AbstractMailer
{
    /**
     * Mandrill client.
     *
     * @var ClientInterface
     */
    protected $client;

    /**
     * Constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Creates a new sender insatance.
     *
     * @param string $email
     * @param string $name
     *
     * @return Sender
     */
    protected function createSender($email, $name = '')
    {
        return new Sender($email, $name);
    }

    /**
     * Creates a new Message instance.
     *
     * @param mixed  $recipients
     * @param mixed  $sender
     * @param string $subject
     * @param string $content
     *
     * @return Message
     */
    protected function createMessage($recipients, $sender, $subject, $content)
    {
        return Message::create($recipients, $sender)
            ->setSubject($subject)
            ->setHtmlContent($content);
    }
}
