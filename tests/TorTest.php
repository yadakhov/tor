<?php

require __DIR__.'/../vendor/autoload.php';

use Yadakhov\Tor;

class TorTest extends \PHPUnit_Framework_TestCase
{
    public function __construct()
    {
        $this->tor = new Tor();
        $this->tor->start();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testConstructor()
    {
        $this->assertTrue($this->tor instanceof Tor);
    }

    public function testCommandInvalidArgument()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->tor->command('everything');
    }

    public function testCommandStatus()
    {
        $command = $this->tor->command('status');

        $this->assertEquals(0, $command->getExitCode());
    }

    public function testIsRunning()
    {
        $this->tor->isRunning();
    }

    public function testCurlExists()
    {
        $this->assertTrue(function_exists('curl_version'));
    }

    public function testStart()
    {
        $this->tor->stop();
        $command = $this->tor->start();

        $this->assertStringStartsWith('* Starting tor daemon', $command->getOutput());
    }

    public function testStop()
    {
        $command = $this->tor->stop();

        $this->assertStringStartsWith('* Stopping tor daemon', $command->getOutput());
        $this->tor->start();
    }

    public function testReload()
    {
        $command = $this->tor->reload();

        $this->assertStringEndsWith('done.', $command->getOutput());
    }

    public function testForceReload()
    {
        $command = $this->tor->forceReload();
        $this->assertStringEndsWith('done.', $command->getOutput());
    }

    public function testStatus()
    {
        $command = $this->tor->status();

        $this->assertEquals('* tor is running', $command->getOutput());
    }

    public function testNewIp()
    {
        $this->tor->newIp();
    }

    public function testGetRandomHeader()
    {
        $header = $this->tor->getRandomHeader();
        $this->assertTrue(is_array($header));

        $this->assertEquals(1, count($header));
    }
}
