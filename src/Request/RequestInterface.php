<?php

/*
 * This file is part of the yandex-pdd-api project.
 *
 * (c) AmaxLab 2017 <http://www.amaxlab.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AmaxLab\YandexPddApi\Request;

/**
 * @author Egor Zyuskin <ezyuskin@amaxlab.ru>
 */
interface RequestInterface
{
    /**
     * @return string
     */
    public function getUri();

    /**
     * @return string
     */
    public function getMethod();

    /**
     * @return array
     */
    public function getParams();
}
