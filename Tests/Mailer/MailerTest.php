<?php

/*
 * This file is part of the Helthe Mandrill package.
 *
 * (c) Carl Alexander <carlalexander@helthe.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Helthe\Component\Mandrill\Tests\Mailer;

use Helthe\Component\Mandrill\Mailer\Mailer;
use Helthe\Component\Mandrill\Message\Message;

class MailerTest extends \PHPUnit_Framework_TestCase
{
    public function testSendMessage()
    {
        $client = $this->getClientMock();
        $message = Message::create('foo@bar.com', 'bar@foo.com')
                          ->setSubject('Foo Bar')
                          ->setHtmlContent('some content');

        $client->expects($this->once())
               ->method('sendMessage')
               ->with($this->equalTo($message));

        $mailer = new Mailer($client);

        $mailer->sendMessage('foo@bar.com', 'bar@foo.com', 'Foo Bar', 'some content');
    }

    /**
     * Get a mock of the Mandrill client.
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function getClientMock()
    {
        return $this->getMock('Helthe\Component\Mandrill\ClientInterface');
    }
}
