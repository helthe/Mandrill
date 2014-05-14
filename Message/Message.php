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

use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Transactional message implementing a fluent interface.
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */
class Message implements NormalizableInterface
{
    /**
     * HTML content of the message.
     *
     * @var string
     */
    private $html;

    /**
     * Text content of the message.
     *
     * @var string
     */
    private $text;

    /**
     * Message subject.
     *
     * @var string
     */
    private $subject;

    /**
     * Message sender.
     *
     * @var Sender
     */
    private $sender;

    /**
     * Message recipients.
     *
     * @var Recipient[]
     */
    private $recipients;

    /**
     * Message headers.
     *
     * @var array
     */
    private $headers;

    /**
     * Constuctor.
     *
     * @param mixed $recipients
     * @param mixed $sender
     */
    public function __construct($recipients, $sender)
    {
        $this->headers = array();
        $this->recipients = array();

        $this->setSender($sender);

        if (!is_array($recipients)) {
            $recipients = array($recipients);
        }

        array_walk($recipients, array($this, 'addRecipient'));
    }

    /**
     * Creates a new message.
     *
     * @param mixed $recipients
     * @param mixed $sender
     *
     * @return Message
     */
    public static function create($recipients, $sender)
    {
        return new self($recipients, $sender);
    }

    /**
     * Add a new message header. Will replace any previously set header
     * with the same name.
     *
     * @param string $name
     * @param string $value
     *
     * @return Message
     */
    public function addHeader($name, $value)
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * Add a message recipient.
     *
     * @param mixed $recipient
     *
     * @return Message
     */
    public function addRecipient($recipient)
    {
        if (is_string($recipient)) {
            $recipient = new Recipient($recipient);
        } elseif (!$recipient instanceof Recipient) {
            throw new \InvalidArgumentException('$recipient must be a string or an instance of Recipient.');
        }

        $this->recipients[] = $recipient;

        return $this;
    }

    /**
     * Get the message headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Get the HTML content of the message.
     *
     * @return string
     */
    public function getHtmlContent()
    {
        return $this->html;
    }

    /**
     * Get the recipients of the message.
     *
     * @return Recipient[]
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * Get the message sender.
     *
     * @return Sender
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Get the subject of the message.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Get the text content of the message.
     *
     * @return string
     */
    public function getTextContent()
    {
        return $this->text;
    }

    /**
     * Set the message headers.
     *
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Set the HTML message content.
     *
     * @param string $html
     *
     * @return Message
     */
    public function setHtmlContent($html)
    {
        $this->html = $html;

        return $this;
    }

    /**
     * Set message sender.
     *
     * @param mixed $sender
     *
     * @return Message
     */
    public function setSender($sender)
    {
        if (is_string($sender)) {
            $sender = new Sender($sender);
        } elseif (!$sender instanceof Sender) {
            throw new \InvalidArgumentException('$sender must be a string or an instance of Sender.');
        }

        $this->sender = $sender;

        return $this;
    }

    /**
     * Set the message subject.
     *
     * @param string $subject
     *
     * @return Message
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Set the text message content.
     *
     * @param string $text
     *
     * @return Message
     */
    public function setTextContent($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, $format = null, array $context = array())
    {
        $data = array(
            'headers' => $this->headers,
            'html' => $this->html,
            'text' => $this->text,
            'subject' => $this->subject,
            'from_email' => $this->sender->getEmail(),
            'from_name' => $this->sender->getName(),
            'to' => array()
        );

        foreach ($this->recipients as $recipient) {
            $data['to'][] = $recipient->normalize($normalizer, $format, $context);
        }

        return $data;
    }
}
