<?php

namespace MemMemov\Ndb;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    protected $socket;

    protected function setUp()
    {
        $this->socket = $this->getMockBuilder(Socket::class)->getMock();
    }

    public function testItCreatesNode()
    {
        $client = new Client($this->socket);

        $this->socket->expects($this->once())
            ->method('send')
            ->with('create');

        $this->socket->expects($this->once())
            ->method('receive')
            ->willReturn(1);

        $id = $client->create();

        $this->assertEquals($id, 1);
    }

    public function testItReadsNode()
    {
        $client = new Client($this->socket);

        $this->socket->expects($this->once())
            ->method('send')
            ->with('read 1');

        $this->socket->expects($this->once())
            ->method('receive')
            ->willReturn('3 5 7');

        $ids = $client->read(1);

        $this->assertEquals($ids, [3, 5, 7]);
    }

    public function testItConnectsNodes()
    {
        $client = new Client($this->socket);

        $this->socket->expects($this->once())
            ->method('send')
            ->with('connect 1 3');

        $this->socket->expects($this->once())
            ->method('receive')
            ->willReturn('');

        $client->connect(1, 3);
    }

    public function testItIntersectsNodes()
    {
        $client = new Client($this->socket);

        $this->socket->expects($this->once())
            ->method('send')
            ->with('intersect 1 19 27');

        $this->socket->expects($this->once())
            ->method('receive')
            ->willReturn('3 801');

        $ids = $client->intersect([1, 19, 27]);

        $this->assertEquals($ids, [3, 801]);
    }

    public function testItUnionsNodes()
    {
        $client = new Client($this->socket);

        $this->socket->expects($this->once())
            ->method('send')
            ->with('union 1 19 27');

        $this->socket->expects($this->once())
            ->method('receive')
            ->willReturn('3 801 943 67');

        $ids = $client->union([1, 19, 27]);

        $this->assertEquals($ids, [3, 801, 943, 67]);
    }

    public function testItDiffsNodes()
    {
        $client = new Client($this->socket);

        $this->socket->expects($this->once())
            ->method('send')
            ->with('difference 1 19 27');

        $this->socket->expects($this->once())
            ->method('receive')
            ->willReturn('3');

        $ids = $client->difference([1, 19, 27]);

        $this->assertEquals($ids, [3]);
    }

    public function testItFiltersInsiders()
    {
        $client = new Client($this->socket);

        $this->socket->expects($this->once())
            ->method('send')
            ->with('insiders 1 3 567 25');

        $this->socket->expects($this->once())
            ->method('receive')
            ->willReturn('3 25');

        $ids = $client->insiders(1, [3, 567, 25]);

        $this->assertEquals($ids, [3, 25]);
    }

    public function testItFiltersOutsiders()
    {
        $client = new Client($this->socket);

        $this->socket->expects($this->once())
            ->method('send')
            ->with('outsiders 1 3 567 25');

        $this->socket->expects($this->once())
            ->method('receive')
            ->willReturn('567');

        $ids = $client->outsiders(1, [3, 567, 25]);

        $this->assertEquals($ids, [567]);
    }
}