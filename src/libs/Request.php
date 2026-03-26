<?php

/*
 * This file is part of the Splash package.
 *
 * (c) Evans Owusu Ofori <vansbeck07@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Splash\Simulator\Libs;

use function Vansbeck07\Dotenv\env;

class Request
{
    protected $requiredParams = [];

    public function __construct()
    {
        $this->requiredParams = [
            'endpoint',
            env('USER_PHONE_PARAM_NAME', 'msisdn'),
            env('USER_NETWORK_PARAM_NAME', 'network'),
            env('SESSION_ID_PARAM_NAME', 'sessionID'),
            env('REQUEST_TYPE_PARAM_NAME', 'ussdServiceOp'),
            env('USER_RESPONSE_PARAM_NAME', 'ussdString'),
        ];

        $this->data = $_POST;
        $this->checkRequiredParams($this->data);
    }

    public function checkRequiredParams($params)
    {
        foreach ($this->requiredParams as $param) {
            if (!isset($params[$param])) {
                throw new \Exception('Parameter"'.$param.'" is required');
            }
        }
    }

    public function data()
    {
        return $this->data;
    }
}
