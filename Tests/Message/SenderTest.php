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

use Helthe\Component\Mandrill\Message\Sender;

class SenderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetEmail()
    {
        $sender = new Sender('foo@bar.com');

        $this->assertSame('foo@bar.com', $sender->getEmail());
    }

    public function testGetName()
    {
        $sender = new Sender('foo@bar.com', 'Foo');

        $this->assertSame('Foo', $sender->getName());
    }
}
