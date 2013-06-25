<?php

namespace Stack;

use Pimple;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

class SslTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function handlesInsecureRequest()
    {
        $app = $this->getHttpKernelMock(Response::create('ok'));
        $sslApp = new Ssl($app);
        $response = $sslApp->handle(Request::create('/auth'));
        $this->assertContains('ok', $response->getContent());
    }

    private function getHttpKernelMock(Response $response)
    {
        $app = $this->getMock('Symfony\Component\HttpKernel\HttpKernelInterface');
        $app->expects($this->any())
            ->method('handle')
            ->with($this->isInstanceOf('Symfony\Component\HttpFoundation\Request'))
            ->will($this->returnValue($response))
        ;

        return $app;
    }
}
