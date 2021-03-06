<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis;

use \PHPUnit_Framework_TestCase as StandardTestCase;

/**
 * @todo ConnectionParameters::define();
 * @todo ConnectionParameters::undefine();
 */
class ConnectionParametersTest extends StandardTestCase
{
    /**
     * @group disconnected
     */
    public function testDefaultValues()
    {
        $defaults = $this->getDefaultParametersArray();
        $parameters = new ConnectionParameters();

        $this->assertEquals($defaults['scheme'], $parameters->scheme);
        $this->assertEquals($defaults['host'], $parameters->host);
        $this->assertEquals($defaults['port'], $parameters->port);
        $this->assertEquals($defaults['throw_errors'], $parameters->throw_errors);
        $this->assertEquals($defaults['iterable_multibulk'], $parameters->iterable_multibulk);
        $this->assertEquals($defaults['connection_async'], $parameters->connection_async);
        $this->assertEquals($defaults['connection_persistent'], $parameters->connection_persistent);
        $this->assertEquals($defaults['connection_timeout'], $parameters->connection_timeout);
        $this->assertEquals($defaults['read_write_timeout'], $parameters->read_write_timeout);
        $this->assertEquals($defaults['database'], $parameters->database);
        $this->assertEquals($defaults['password'], $parameters->password);
        $this->assertEquals($defaults['alias'], $parameters->alias);
        $this->assertEquals($defaults['weight'], $parameters->weight);
        $this->assertEquals($defaults['path'], $parameters->path);
    }

    /**
     * @group disconnected
     */
    public function testIsSet()
    {
        $parameters = new ConnectionParameters();

        $this->assertTrue(isset($parameters->scheme));
        $this->assertFalse(isset($parameters->unknown));
    }

    /**
     * @group disconnected
     */
    public function testIsSetByUser()
    {
        $parameters = new ConnectionParameters(array('port' => 7000, 'custom' => 'foobar'));

        $this->assertTrue(isset($parameters->scheme));
        $this->assertFalse($parameters->isSetByUser('scheme'));

        $this->assertTrue(isset($parameters->port));
        $this->assertTrue($parameters->isSetByUser('port'));

        $this->assertTrue(isset($parameters->custom));
        $this->assertTrue($parameters->isSetByUser('custom'));

        $this->assertFalse(isset($parameters->unknown));
        $this->assertFalse($parameters->isSetByUser('unknown'));
    }

    /**
     * @group disconnected
     */
    public function testConstructWithUriString()
    {
        $defaults = $this->getDefaultParametersArray();

        $overrides = array(
            'port' => 7000,
            'database' => 5,
            'throw_errors' => false,
            'custom' => 'foobar',
        );

        $parameters = new ConnectionParameters($this->getParametersString($overrides));

        $this->assertEquals($defaults['scheme'], $parameters->scheme);
        $this->assertEquals($defaults['host'], $parameters->host);
        $this->assertEquals($overrides['port'], $parameters->port);

        $this->assertEquals($overrides['database'], $parameters->database);
        $this->assertEquals($overrides['throw_errors'], $parameters->throw_errors);

        $this->assertTrue(isset($parameters->custom));
        $this->assertTrue($parameters->isSetByUser('custom'));
        $this->assertEquals($overrides['custom'], $parameters->custom);

        $this->assertFalse(isset($parameters->unknown));
        $this->assertFalse($parameters->isSetByUser('unknown'));
    }

    /**
     * @group disconnected
     */
    public function testToArray()
    {
        $additional = array('port' => 7000, 'custom' => 'foobar');
        $parameters = new ConnectionParameters($additional);

        $this->assertEquals($this->getParametersArray($additional), $parameters->toArray());
    }

    /**
     * @group disconnected
     */
    public function testToString()
    {
        $uri = 'tcp://localhost:7000/?database=15&custom=foobar&throw_errors=0';
        $parameters = new ConnectionParameters($uri);

        $this->assertEquals($uri, (string) $parameters);
    }

    /**
     * @group disconnected
     * @todo Does it actually make sense?
     */
    public function testToStringOmitPassword()
    {
        $uri = 'tcp://localhost:7000/?database=15&custom=foobar&throw_errors=0';
        $parameters = new ConnectionParameters($uri . '&password=foobar');

        $this->assertEquals($uri, (string) $parameters);
    }

    /**
     * @group disconnected
     */
    public function testSerialization()
    {
        $parameters = new ConnectionParameters(array('port' => 7000, 'custom' => 'foobar'));
        $unserialized = unserialize(serialize($parameters));

        $this->assertEquals($parameters->scheme, $unserialized->scheme);
        $this->assertEquals($parameters->port, $unserialized->port);

        $this->assertTrue(isset($unserialized->custom));
        $this->assertTrue($unserialized->isSetByUser('custom'));
        $this->assertEquals($parameters->custom, $unserialized->custom);

        $this->assertFalse(isset($unserialized->unknown));
        $this->assertFalse($unserialized->isSetByUser('unknown'));
    }

    // ******************************************************************** //
    // ---- HELPER METHODS ------------------------------------------------ //
    // ******************************************************************** //

    /**
     * Returns a named array with the default connection parameters and their values.
     *
     * @return Array Default connection parameters.
     */
    protected function getDefaultParametersArray()
    {
        return array(
            'scheme' => 'tcp',
            'host' => '127.0.0.1',
            'port' => 6379,
            'database' => null,
            'password' => null,
            'connection_async' => false,
            'connection_persistent' => false,
            'connection_timeout' => 5.0,
            'read_write_timeout' => null,
            'alias' => null,
            'weight' => null,
            'path' => null,
            'iterable_multibulk' => false,
            'throw_errors' => true,
        );
    }

    /**
     * Returns a named array with the default connection parameters merged with
     * the specified additional parameters.
     *
     * @param Array $additional Additional connection parameters.
     * @return Array Connection parameters.
     */
    protected function getParametersArray(Array $additional)
    {
        return array_merge($this->getDefaultParametersArray(), $additional);
    }

    /**
     * Returns an URI string representation of the specified connection parameters.
     *
     * @param Array $parameters Array of connection parameters.
     * @return String URI string.
     */
    protected function getParametersString(Array $parameters)
    {
        $defaults = $this->getDefaultParametersArray();

        $scheme = isset($parameters['scheme']) ? $parameters['scheme'] : $defaults['scheme'];
        $host = isset($parameters['host']) ? $parameters['host'] : $defaults['host'];
        $port = isset($parameters['port']) ? $parameters['port'] : $defaults['port'];

        unset($parameters['scheme'], $parameters['host'], $parameters['port']);
        $uriString = "$scheme://$host:$port/?";

        foreach ($parameters as $k => $v) {
            $uriString .= "$k=$v&";
        }

        return $uriString;
    }
}
