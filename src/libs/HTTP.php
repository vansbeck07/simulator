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

/**
 * HTTP requests utility class.
 *
 * @author Evans Owusu Ofori <vansbeck07@gmail.com>
 */
class HTTP
{
    public static function post(
        array $payload,
        string $endpoint,
        string $requestDescription = '',
        array $customCurlOptions = []
    ) {
        $defaultCurlOptions = [
            CURLOPT_URL            => $endpoint,
            CURLOPT_POST           => 1,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_ENCODING       => 'UTF-8',
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_TIMEOUT        => 60,
        ];
        $curlOptions = array_replace_recursive(
            $defaultCurlOptions,
            $customCurlOptions
        );

        $curlHandle = curl_init();
        curl_setopt_array($curlHandle, $curlOptions);
        $result = curl_exec($curlHandle);
        $err = curl_error($curlHandle);
        curl_close($curlHandle);

        $response = [
            'SUCCESS' => true,
            'data'    => $result,
        ];

        if ($err) {
            $description = '';

            if ($requestDescription) {
                $description = '<br/><span style="color:red;">ERROR POST REQUEST:</span> '.$requestDescription.'<br/>';
            }

            $response = [
                'SUCCESS' => false,
                'error'   => $description.$err,
            ];
        }

        return $response;
    }
}
