<?php

/*
 * This file is part of the yandex-pdd-api project.
 *
 * (c) AmaxLab 2017 <http://www.amaxlab.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AmaxLab\YandexPddApi\Manager;

use AmaxLab\YandexPddApi\Request\GetDomainsListRequest;
use AmaxLab\YandexPddApi\Request\GetRegistrationStatusDomainRequest;
use AmaxLab\YandexPddApi\Request\RegisterDomainRequest;
use AmaxLab\YandexPddApi\Response\GetDomainsListResponse;
use AmaxLab\YandexPddApi\Response\GetRegistrationStatusDomainsResponse;
use AmaxLab\YandexPddApi\Response\RegisterDomainResponse;

/**
 * @author Egor Zyuskin <ezyuskin@amaxlab.ru>
 */
class DomainManager extends AbstractManager
{
    /**
     * @return GetDomainsListResponse|object
     */
    public function getDomainList()
    {
        return $this->request(new GetDomainsListRequest(), 'AmaxLab\YandexPddApi\Response\GetDomainsListResponse');
    }

    /**
     * @param string $domainName
     *
     * @return RegisterDomainResponse|object
     */
    public function registerDomain($domainName)
    {
        return $this->request(new RegisterDomainRequest($domainName), 'AmaxLab\YandexPddApi\Response\RegisterDomainResponse');
    }

    /**
     * @param string $domainName
     *
     * @return GetRegistrationStatusDomainsResponse|object
     */
    public function getRegistrationStatusDomain($domainName)
    {
        return $this->request(new GetRegistrationStatusDomainRequest($domainName), 'AmaxLab\YandexPddApi\Response\GetRegistrationStatusDomainsResponse');
    }
}
