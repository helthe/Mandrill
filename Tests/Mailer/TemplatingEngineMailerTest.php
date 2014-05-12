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

use Helthe\Component\Mandrill\Mailer\TemplatingEngineMailer;
use Helthe\Component\Mandrill\Message\Message;

class TemplatingEngineMailerTest extends \PHPUnit_Framework_TestCase
{
    public function testSendMessage()
    {
        $client = $this->getClientMock();
        $engine = $this->getEngineMock();
        $message = Message::create('foo@bar.com', 'bar@foo.com')
                          ->setSubject('Foo Bar')
                          ->setHtmlContent('some content');

        $client->expects($this->once())
               ->method('sendMessage')
               ->with($this->equalTo($message));

        $engine->expects($this->once())
               ->method('render')
               ->with($this->equalTo('email.twig'), $this->equalTo(array()))
               ->will($this->returnValue('some content'));

        $mailer = new TemplatingEngineMailer($client, $engine);

        $mailer->sendMessage('foo@bar.com', 'bar@foo.com', 'Foo Bar', 'email.twig');
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

    /**
     * Get a mock of a Symfony templating engine.
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function getEngineMock()
    {
        return $this->getMock('Symfony\Component\Templating\EngineInterface');
    }
}