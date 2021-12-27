<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;

class IpFinderTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnIpWithoutEndOfLine()
    {
        // Mock do Guzzle\Client usando Guzzle\MockHandler
        $mock = new MockHandler([new Response(200, [], "127.0.0.1\n")]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        // Instanciando e testando IPFinder
        $ipFinder = new IPFinder($client);
        $ip = $ipFinder->findIp();
        $this->assertEquals("127.0.0.1", $ip);
    }
}
