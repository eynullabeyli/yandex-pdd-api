<?php

/*
 * This file is part of the yandex-pdd-api project.
 *
 * (c) AmaxLab 2017 <http://www.amaxlab.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AmaxLab\YandexPddApi\Tests\Manager;

use AmaxLab\YandexPddApi\Curl\CurlResponse;
use AmaxLab\YandexPddApi\Manager\DomainManager;
use AmaxLab\YandexPddApi\Response\Domain\GetDomainsListResponse;
use Xpmock\TestCaseTrait;

/**
 * @author Egor Zyuskin <ezyuskin@amaxlab.ru>
 */
class DomainManagerTest extends \PHPUnit_Framework_TestCase
{
    use TestCaseTrait;

    public function testGetDomainsList()
    {
        $curl = $this->mock('AmaxLab\YandexPddApi\Curl\CurlClientInterface')
            ->request((new CurlResponse(200, '{"direction":"asc","on_page":20,"success":"ok","domains":[{"status":"added","from_registrar":"no","name":"test.com","ws_technical":"no","logo_enabled":true,"master_admin":true,"nsdelegated":true,"emails-max-count":1000,"emails-count":0,"dkim-ready":true,"logo_url":"http//logo.url","stage":"added","aliases":["test2.com"]}],"found":1,"total":1,"page":1,"order":"default"}')))
            ->new()
        ;

        $domainList = (new DomainManager(''))->setCurl($curl)->getDomainList();
        $domains = $domainList->getDomains();
        $aliases = $domains[0]->getAliases();

        $this->assertEquals(true, $domainList instanceof GetDomainsListResponse);
        $this->assertEquals(1, count($domains));
        $this->assertEquals('added', $domains[0]->getStatus());
        $this->assertEquals('no', $domains[0]->getFromRegistrar());
        $this->assertEquals('test.com', $domains[0]->getName());
        $this->assertEquals('no', $domains[0]->getWsTechnical());
        $this->assertEquals(true, $domains[0]->isLogoEnabled());
        $this->assertEquals(true, $domains[0]->isMasterAdmin());
        $this->assertEquals(true, $domains[0]->isNsdelegated());
        $this->assertEquals(1000, $domains[0]->getEmailsMaxCount());
        $this->assertEquals(0, $domains[0]->getEmailsCount());
        $this->assertEquals(true, $domains[0]->isDkimReady());
        $this->assertEquals('http//logo.url', $domains[0]->getLogoUrl());
        $this->assertEquals('added', $domains[0]->getStage());
        $this->assertEquals(1, count($aliases));
        $this->assertEquals('test2.com', $aliases[0]);
    }

    public function testRegisterDomain()
    {
        $curl = $this->mock('AmaxLab\YandexPddApi\Curl\CurlClientInterface')
            ->request((new CurlResponse(200, '{"status": "domain-activate", "secrets": {"content": "c6ccecffb250", "name": "bbc1fc0d7a3a"}, "domain": "test.com", "success": "ok", "stage": "owner-check"}')))
            ->new()
        ;

        $response = (new DomainManager(''))->setCurl($curl)->registerDomain('test.com');
        $this->assertEquals('test.com', $response->getDomain());
        $this->assertEquals('domain-activate', $response->getStatus());
        $this->assertEquals('owner-check', $response->getStage());
        $this->assertEquals('c6ccecffb250', $response->getSecrets()->getContent());
        $this->assertEquals('bbc1fc0d7a3a', $response->getSecrets()->getName());
    }

    public function testGetDomainRegistrationStatus()
    {
        $curl = $this->mock('AmaxLab\YandexPddApi\Curl\CurlClientInterface')
            ->request((new CurlResponse(200, '{"status": "domain-activate", "domain": "test.com", "success": "ok", "secrets": {"content": "a4f9aace399d", "name": "ea1aebbbf7c0"}, "last_check": "2017-07-27T17:48:43Z", "next_check": "2017-07-27T17:59:00Z", "check_results": "no cname, no file", "stage": "owner-check"}')))
            ->new()
        ;

        $response = (new DomainManager(''))->setCurl($curl)->getRegistrationStatusDomain('test.com');
        $this->assertEquals(new \DateTime('2017-07-27T17:48:43Z'), $response->getLastCheck());
        $this->assertEquals(new \DateTime('2017-07-27T17:59:00Z'), $response->getNextCheck());
        $this->assertEquals('no cname, no file', $response->getCheckResults());
    }

    public function testGetDomainSettings()
    {
        $curl = $this->mock('AmaxLab\YandexPddApi\Curl\CurlClientInterface')
            ->request((new CurlResponse(200, '{"status": "added", "from_registrar": "no", "imap_enabled": 1, "success": "ok", "default_theme": "", "country": "ru", "ws_technical": "no", "can_users_change_password": "yes", "domain": "test.com", "default_uid": 0, "master_admin": "yes", "roster_enabled": "yes", "pop_enabled": 1, "delegated": "no", "logo_url": "http//logo.url", "stage": "added"}')))
            ->new()
        ;

        $response = (new DomainManager(''))->setCurl($curl)->getDomainSettings('test.com');
        $this->assertEquals('added', $response->getStatus());
        $this->assertEquals('no', $response->getFromRegistrar());
        $this->assertEquals(true, $response->isImapEnabled());
        $this->assertEquals('', $response->getDefaultTheme());
        $this->assertEquals('ru', $response->getCountry());
        $this->assertEquals('no', $response->getWsTechnical());
        $this->assertEquals('yes', $response->getCanUsersChangePassword());
        $this->assertEquals('test.com', $response->getDomain());
        $this->assertEquals(0, $response->getDefaultUid());
        $this->assertEquals('yes', $response->getMasterAdmin());
        $this->assertEquals('yes', $response->getRosterEnabled());
        $this->assertEquals(true, $response->isPopEnabled());
        $this->assertEquals('no', $response->getDelegated());
        $this->assertEquals('http//logo.url', $response->getLogoUrl());
        $this->assertEquals('added', $response->getStage());
    }

    public function testDeleteDomain()
    {
        $curl = $this->mock('AmaxLab\YandexPddApi\Curl\CurlClientInterface')
            ->request((new CurlResponse(200, '{"domain": "domain.com", "success": "ok"}')))
            ->new()
        ;

        $response = (new DomainManager(''))->setCurl($curl)->deleteDomain('domain.com');
        $this->assertEquals('domain.com', $response->getDomain());
    }

    public function testSetDomainCountry()
    {
        $curl = $this->mock('AmaxLab\YandexPddApi\Curl\CurlClientInterface')
            ->request((new CurlResponse(200, '{"country": "ru", "domain": "domain.com", "success": "ok"}')))
            ->new()
        ;

        $response = (new DomainManager(''))->setCurl($curl)->setDomainCountry('domain.com', 'ru');
        $this->assertEquals('domain.com', $response->getDomain());
        $this->assertEquals('ru', $response->getCountry());
    }
}
