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
 * Recipient of a transactional message.
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */
class Recipient implements NormalizableInterface
{
    /**
     * Recipient's email address.
     *
     * @var string
     */
    private $email;

    /**
     * Display name of the recipient.
     *
     * @var string
     */
    private $name;

    /**
     * Header type for recipient. Choices are to, cc or bcc.
     *
     * @var string
     */
    private $type;

    /**
     * Constructor.
     *
     * @param string $email
     * @param string $name
     * @param string $type
     */
    public function __construct($email, $name = '', $type = 'to')
    {
        $this->email = $email;
        $this->name = $name;
        $this->type = strtolower($type);

        if (!in_array($this->type, array('to', 'cc', 'bcc'))) {
            throw new \InvalidArgumentException('$type should be either "to", "cc" or "bcc".');
        }

    }

    /**
     * Get the recipient's email address.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the display name of the recipient.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the header type for this recipient.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, $format = null, array $context = array())
    {
        return array(
            'email' => $this->email,
            'name'  => $this->name,
            'type'  => $this->type
        );
    }
}
