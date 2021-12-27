<?php

namespace App;

use App\Entity\Location;
use App\Exception\ErrorOnFindingLocation;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use App\Service\LocationFinder;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;

class LocationFinderTest extends TestCase
{
    public function dadosDaRequisicao()
    {
        return $json = '{
            "continent_code": "SA",
            "country_name": "Brazil",
            "city": "Tiradentes",
            "timezone": "America/Sao_Paulo"
        }';
    }

    /**
     * @test
     * 
     * Validação de exceção para código != 200
     */
    public function shouldThrowException()
    {
        $this->expectException(ErrorOnFindingLocation::class);
        // Mock do Guzzle\Client usando Guzzle\MockHandler
        $mock = new MockHandler([new Response(201, [], "127.0.0.1\n")]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        // Instanciando e testando LocationFinder
        $locationFinder = new LocationFinder($client);
        $locationFinder->findLocation("127.0.0.1");
    }

    /**
     * @test
     * 
     * Validação se o objeto retornado é do tipo Location
     */
    public function shouldReturnALocation()
    {
        // Mock do Guzzle\Client usando Guzzle\MockHandler
        $mock = new MockHandler([
            new Response(
                200,
                [
                    "content-type" => "application/json"
                ],
                $this->dadosDaRequisicao()
            )
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        // Instanciando e testando LocationFinder
        $locationFinder = new LocationFinder($client);
        $location = $locationFinder->findLocation("127.0.0.1");
        $this->assertInstanceOf(Location::class, $location, 'Tipo de retorno não é do tipo Location');
    }
}
