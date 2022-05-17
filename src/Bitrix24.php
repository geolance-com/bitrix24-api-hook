<?php
/**
 * Created by PhpStorm.
 * User: fomvasss
 * Date: 08.04.19
 * Time: 17:28
 */

namespace Fomvasss\Bitrix24ApiHook;

class Bitrix24
{
    protected $baseUrl;

    protected $userId;

    protected $webHookCode;

    protected $hookUrl;

    /**
     * Bitrix24 constructor.
     */
    public function __construct(string $baseUrl, int $userId, string $webHookCode)
    {
        $this->baseUrl = $baseUrl;

        $this->userId = $userId;

        $this->webHookCode = $webHookCode;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $apiMethod = $this->getApiMethod($name);

        $queryUrl = $this->getApiUrl($apiMethod);

        $queryData = http_build_query(...$arguments);

        return $this->curl($queryUrl, $queryData);
    }

    /**
     * Example: crmLeadAdd => crm.lead.add
     *
     * @param $name
     * @return string
     */
    protected function getApiMethod($name)
    {
        preg_match_all('/((?:^|[A-Z])[a-z]+)/', $name, $matches);

        $segments = array_map(function ($item) {
            return mb_strtolower($item);
        }, $matches[1]);

        return implode('.', $segments);
    }

    /**
     * Example: https://your-domen.bitrix24.ru/rest/13/9cybrkhzxxf28zl4/profile/
     *
     * @param string $method
     * @return string
     */
    protected function getApiUrl(string $method = '')
    {
        return $this->baseUrl . '/rest/' . $this->userId . '/' .$this->webHookCode . '/' . $method;
    }

    /**
     * @param string $queryUrl
     * @param string $queryData
     * @return mixed
     */
    protected function curl(string $queryUrl, string $queryData)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $queryUrl,
            CURLOPT_POSTFIELDS => $queryData,
        ));
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result, 1);

        if (array_key_exists('error', $result)) {
            throw new \Exception("Query: [$queryUrl] " . $result['error_description']);
        }

        return $result;
    }
}