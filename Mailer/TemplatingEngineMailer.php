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
use Symfony\Component\Templating\EngineInterface;

/**
 * Mandrill mailer that uses a templating engine to render HTML emails.
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */
class TemplatingEngineMailer extends AbstractMailer
{
    /**
     * Templating engine.
     *
     * @var EngineInterface
     */
    protected $templating;

    /**
     * Constructor.
     *
     * @param ClientInterface $client
     * @param EngineInterface $templating
     */
    public function __construct(ClientInterface $client, EngineInterface $templating)
    {
        parent::__construct($client);

        $this->templating = $templating;
    }

    /**
     * Send a transactional message using the given template.
     *
     * @param mixed  $recipients
     * @param mixed  $sender
     * @param string $subject
     * @param string $templateName
     * @param array  $context
     */
    public function sendMessage($recipients, $sender, $subject, $templateName, array $context = array())
    {
        $this->client->sendMessage($this->createMessage(
            $recipients,
            $sender,
            $subject,
            $this->render($templateName, $context)
        ));
    }

    /**
     * Renders the given template.
     *
     * @param string $templateName
     * @param array  $context
     *
     * @return string
     */
    protected function render($templateName, array $context = array())
    {
        return $this->templating->render($templateName, $context);
    }
}
