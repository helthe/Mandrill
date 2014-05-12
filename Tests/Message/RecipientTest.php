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

use Helthe\Component\Mandrill\Message\Recipient;

class RecipientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorWithInvalidType()
    {
        $recipient = new Recipient('foo@bar.com', 'Foo', 'bar');
    }

    public function testGetEmail()
    {
        $recipient = new Recipient('foo@bar.com');

        $this->assertSame('foo@bar.com', $recipient->getEmail());
    }

    public function testGetName()
    {
        $recipient = new Recipient('foo@bar.com', 'Foo');

        $this->assertSame('Foo', $recipient->getName());
    }

    public function testGetType()
    {
        $recipient = new Recipient('foo@bar.com', 'Foo', 'Bcc');

        $this->assertSame('bcc', $recipient->getType());
    }

    public function testNormalize()
    {
        $normalizer = $this->getNormalizerMock();
        $recipient = new Recipient('foo@bar.com', 'Foo');

        $this->assertEquals(array('email' => 'foo@bar.com', 'name' => 'Foo', 'type' => 'to'), $recipient->normalize($normalizer));
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
