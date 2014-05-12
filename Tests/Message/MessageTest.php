<?php

/*
 * This file is part of the Helthe Mandrill package.
 *
 * (c) Carl Alexander <carlalexander@helthe.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Helthe\Component\Mandrill\Tests\Message;

use Helthe\Component\Mandrill\Message\Message;
use Helthe\Component\Mandrill\Message\Recipient;
use Helthe\Component\Mandrill\Message\Sender;

class MessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorWithInvalidRecipients()
    {
        $message = new Message(null, 'foo@bar.com');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorWithInvalidRecipientsArray()
    {
        $message = new Message(array('foo@bar.com', null), 'foo@bar.com');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorWithInvalidSender()
    {
        $message = new Message('foo@bar.com', null);
    }

    public function testConstructorWithStrings()
    {
        $message = new Message('foo@bar.com', 'bar@foo.com');

        $this->assertEquals(array(new Recipient('foo@bar.com')), $message->getRecipients());
        $this->assertEquals(new Sender('bar@foo.com'), $message->getSender());
    }

    public function testConstructorWithRecipientsArray()
    {
        $message = new Message(array('foo1@bar.com', 'foo2@bar.com'), 'bar@foo.com');

        $this->assertEquals(array(new Recipient('foo1@bar.com'), new Recipient('foo2@bar.com')), $message->getRecipients());
        $this->assertEquals(new Sender('bar@foo.com'), $message->getSender());
    }

    public function testAddHeader()
    {
        $message = new Message('foo@bar.com', 'bar@foo.com');

        $message->addHeader('foo', 'bar');

        $this->assertSame(array('foo' => 'bar'), $message->getHeaders());
    }

    public function testAddRecipient()
    {
        $message = new Message('foo1@bar.com', 'bar@foo.com');

        $message->addRecipient('foo2@bar.com');

        $this->assertEquals(array(new Recipient('foo1@bar.com'), new Recipient('foo2@bar.com')), $message->getRecipients());
    }

    public function testSetHeaders()
    {
        $message = new Message('foo@bar.com', 'bar@foo.com');

        $message->setHeaders(array('foo' => 'bar'));

        $this->assertSame(array('foo' => 'bar'), $message->getHeaders());
    }

    public function testSetHtmlContent()
    {
        $message = new Message('foo@bar.com', 'bar@foo.com');

        $message->setHtmlContent('html content');

        $this->assertSame('html content', $message->getHtmlContent());
    }

    public function testSetSender()
    {
        $message = new Message('foo@bar.com', 'bar@foo.com');
        $sender = new Sender('new@foo.com');

        $message = $message->setSender($sender);

        $this->assertSame($sender, $message->getSender());
    }

    public function testSetSubject()
    {
        $message = new Message('foo@bar.com', 'bar@foo.com');

        $message->setSubject('Foo Bar');

        $this->assertSame('Foo Bar', $message->getSubject());
    }

    public function testSetTextContent()
    {
        $message = new Message('foo@bar.com', 'bar@foo.com');

        $message->setTextContent('text content');

        $this->assertSame('text content', $message->getTextContent());
    }

    public function testNormalize()
    {
        $normalizer = $this->getNormalizerMock();

        $message = new Message('foo@bar.com', 'bar@foo.com');

        $this->assertEquals(array(
            'from_email' => 'bar@foo.com',
            'from_name' => '',
            'to' => array(array('email' => 'foo@bar.com', 'name' => '', 'type' => 'to')),
            'headers' => array(),
            'html' => null,
            'text' => null,
            'subject' => null
        ), $message->normalize($normalizer));
    }

    /**
     * Get a mock of the Symfony normalizer.
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function getNormalizerMock()
    {
        return $this->getMock('Symfony\Component\Serializer\Normalizer\NormalizerInterface');
    }
}
