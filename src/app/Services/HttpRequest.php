<?php

namespace App\Services;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class HttpRequest
{

    public static function get(string $url, int $timeout = 30, array $headers = [], array $cookies = [], string $domain = ''): PromiseInterface|Response
    {
        return Http::withHeaders($headers)
            ->withCookies($cookies, $domain)
            ->timeout($timeout)
            ->get($url);
    }

    public static function delete(string $url, array $params = [], int $timeout = 30, array $headers = [], array $cookies = [], string $domain = ''): PromiseInterface|Response
    {
        return Http::withHeaders($headers)
            ->withCookies($cookies, $domain)
            ->timeout($timeout)
            ->delete($url, $params);
    }

    public static function post(string $url, array $params, int $timeout = 30, array $headers = [], array $cookies = [], string $domain = '', string $format = 'json'): PromiseInterface|Response
    {
        return self::buildHttpClient($headers, $cookies, $domain, $timeout, $format)
            ->post($url, $params);
    }

    public static function put(string $url, array $params, int $timeout = 30, array $headers = [], array $cookies = [], string $domain = '', string $format = 'json'): PromiseInterface|Response
    {
        return self::buildHttpClient($headers, $cookies, $domain, $timeout, $format)
            ->put($url, $params);
    }

    public static function patch(string $url, array $params, int $timeout = 30, array $headers = [], array $cookies = [], string $domain = '', string $format = 'json'): PromiseInterface|Response
    {
        return self::buildHttpClient($headers, $cookies, $domain, $timeout, $format)
            ->patch($url, $params);
    }

    private static function buildHttpClient(array $headers, array $cookies, string $domain, int $timeout, string $format): PendingRequest
    {
        if (!isset($headers['Accept'])) {
            $headers['Accept'] = 'application/json';
        }

        $client = Http::withHeaders($headers)
            ->withCookies($cookies, $domain)
            ->timeout($timeout);

        return match (strtolower($format)) {
            'form'      => $client->asForm(),
            'multipart' => $client->asMultipart(),
            default     => $client->asJson(), // default
        };
    }

}
