<?php

namespace App\Service;

use App\Exception\InvalidIP4Format;
use App\Service\IPFizzBuzz;
use PHPUnit\Framework\TestCase;

class IPFizzBuzzTest extends TestCase
{
    private IPFizzBuzz $ipFizzBuzz;

    public function setUp(): void
    {
        $this->ipFizzBuzz = new IPFizzBuzz();
    }

    /**
     * @test
     * 
     * Validação se o retorno é "Fizz" quando 
     * o ip é multiplo de 3
     */
    public function shouldReturnFizz()
    {
        $this->assertEquals("Fizz", $this->ipFizzBuzz->getFizzBuzzByIP("127.0.0.3"));
    }

    /**
     * @test
     * 
     * Validação se o retorno é "Fizz" quando 
     * o ip é multiplo de 5
     */
    public function shouldReturnBuzz()
    {
        $this->assertEquals("Buzz", $this->ipFizzBuzz->getFizzBuzzByIP("127.0.0.5"));
    }

    /**
     * @test
     * 
     * Validação se o retorno é "FizzBuzz" quando 
     * o ip é multiplo de 3 e 5
     */
    public function shouldReturnFizzBuzz()
    {
        $this->assertEquals("FizzBuzz", $this->ipFizzBuzz->getFizzBuzzByIP("127.0.0.15"));
    }

    /**
     * @test
     * 
     * Validação se o retorno é o próprio ip 
     * quando o ip não é multiplo de 3 ou 5
     */
    public function shouldReturnHimself()
    {
        $this->assertEquals("7", $this->ipFizzBuzz->getFizzBuzzByIP("127.0.0.7"));
    }
    
    /**
     * @test
     * 
     * Validação de excessão caso o ip não seja válido
     */
    public function shouldThrowException()
    {
        $this->expectException(InvalidIP4Format::class);
        $this->ipFizzBuzz->getFizzBuzzByIP("127.0.0.1a");
    }
}
