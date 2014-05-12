<?php

/*
 * This file is part of the Helthe Mandrill package.
 *
 * (c) Carl Alexander <carlalexander@helthe.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Helthe\Component\Mandrill\Tests;

use Helthe\Component\Mandrill\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $guzzle = $this->getGuzzleClientMock();
        $serializer = $this->getSerializerMock();

        $guzzle->expects($this->once())
               ->method('setDefaultOption')
               ->with($this->equalTo('headers/User-Agent'), $this->equalTo('Helthe-Mandrill/0.1.0'));

        $client = new Client($guzzle, $serializer, 'mandrill_key');
    }

    public function testSendMessage()
    {
        $apiKey = 'mandrill_key';
        $guzzle = $this->getGuzzleClientMock();
        $message = $this->getMessageMock();
        $serializer = $this->getSerializerMock();
        $expected = json_encode(array('key' => $apiKey, 'message' => 'foo'));

        $guzzle->expects($this->once())
               ->method('post')
               ->with('https://mandrillapp.com/api/1.0/messages/send.json', array('body' => $expected));

        $serializer->expects($this->once())
                   ->method('serialize')
                   ->with(array('key' => $apiKey, 'message' => $message))
                   ->will($this->returnValue($expected));

        $client = new Client($guzzle, $serializer, $apiKey);

        $client->sendMessage($message);
    }

    /**
     * Get a mock of the Guzzle client.
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function getGuzzleClientMock()
    {
        return $this->getMock('GuzzleHttp\ClientInterface');
    }

    /**
     * Get a mock of a Mandrill transactional message.
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function getMessageMock()
    {
        return $this->getMockBuilder('Helthe\Component\Mandrill\Message\Message')
                    ->disableOriginalConstructor()
                    ->getMock();
    }

    /**
     * Get a mock of the Symfony serializer.
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function getSerializerMock()
    {
        return $this->getMock('Symfony\Component\Serializer\SerializerInterface');
    }
}
