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

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use Helthe\Component\Mandrill\Message\Message;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Mandrill API client.
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */
class Client implements ClientInterface
{
    /**
     * Mandrill API key.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Guzzle client.
     *
     * @var GuzzleClientInterface
     */
    protected $client;

    /**
     * Serializer.
     *
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * Constructor.
     *
     * @param GuzzleClientInterface $client
     * @param SerializerInterface   $serializer
     * @param string                $apiKey
     */
    public function __construct(GuzzleClientInterface $client, SerializerInterface $serializer, $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
        $this->serializer = $serializer;

        $this->client->setDefaultOption('headers/User-Agent', 'Helthe-Mandrill/' . self::VERSION);
    }

    /**
     * {@inheritdoc}
     */
    public function sendMessage(Message $message)
    {
        $this->client->post(self::BASE_URL . '/messages/send.json', array('body' => $this->serialize(array(
            'message' => $message
        ))));
    }

    /**
     * Serializes the data array.
     *
     * @param array $data
     *
     * @return string
     */
    protected function serialize(array $data)
    {
        // Prepend API key to all serialized data
        $data['key'] = $this->apiKey;

        return $this->serializer->serialize($data, 'json');
    }
}
