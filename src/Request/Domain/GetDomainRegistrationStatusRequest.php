<?php

/*
 * This file is part of the yandex-pdd-api project.
 *
 * (c) AmaxLab 2017 <http://www.amaxlab.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AmaxLab\YandexPddApi\Request\Domain;

use AmaxLab\YandexPddApi\Curl\CurlClient;

/**
 * @author Egor Zyuskin <ezyuskin@amaxlab.ru>
 */
class GetDomainRegistrationStatusRequest extends RegisterDomainRequest
{
    /**
     * @return string
     */
    public function getUri()
    {
        return '/domain/registration_status';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return CurlClient::METHOD_GET;
    }
}
