<?php

/*
 * This file is part of the yandex-pdd-api project.
 *
 * (c) AmaxLab 2017 <http://www.amaxlab.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AmaxLab\YandexPddApi\Tests\Curl;

use AmaxLab\YandexPddApi\Curl\CurlResponse;
use Xpmock\TestCaseTrait;

/**
 * @author Egor Zyuskin <ezyuskin@amanxlab.ru>
 */
class CurlClientTest extends \PHPUnit_Framework_TestCase
{
    use TestCaseTrait;

    public function testResponse()
    {
        $client = $this->mock('AmaxLab\YandexPddApi\Curl\CurlClient')
            ->makeRequest('')
            ->new(false)
        ;

        $this->assertEquals(true, $client->request('GET', '', []) instanceof CurlResponse);
        $this->assertEquals(true, $client->request('POST', '', []) instanceof CurlResponse);
    }
}