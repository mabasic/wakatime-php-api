<?php namespace Mabasic\WakaTime;

use GuzzleHttp\Client;
use Mabasic\WakaTime\Traits\Reports;

class WakaTime
{
    use Reports;

    protected $guzzle;

    protected $api_key;

    protected $api_url = 'https://wakatime.com/api/v1';

    public function __construct(Client $guzzle, $api_key)
    {
        $this->guzzle  = $guzzle;
        $this->api_key = $api_key;
    }

    protected function getHeaders()
    {
        return [
            'verify'  => __DIR__ . '/ca-bundle.crt',
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($this->api_key),
            ],
        ];
    }

    /**
     * Makes a request to the URL and returns a response.
     *
     * @param  [type] $url
     * @return [type]
     */
    protected function makeRequest($resource)
    {
        $url = "{$this->api_url}/{$resource}";

        $response = $this->guzzle->get($url, $this->getHeaders())->getBody();

        return json_decode($response, true);
    }

    /**
     * See: https://wakatime.com/developers#users for details.
     *
     * @return mixed
     */
    public function users($user)
    {
        return $this->makeRequest("users/{$user}");
    }

    /**
     * See: https://wakatime.com/developers#users for details.
     *
     * @return mixed
     */
    public function currentUser()
    {
        return $this->makeRequest("users/current");
    }

    /**
     * See: https://wakatime.com/developers#summaries for details.
     *
     * @param $startDate
     * @param $endDate
     * @param null $project
     * @return mixed
     */
    public function summaries($startDate, $endDate, $project = null)
    {
        if ($project !== null) {
            $project = "&project={$project}";
        }

        return $this->makeRequest("users/current/summaries?start={$startDate}&end={$endDate}" . $project);
    }

    /**
     * See: https://wakatime.com/developers#stats for details.
     *
     * @param $range
     * @param null $project
     * @return mixed
     */
    public function stats($range, $project = null)
    {
        if ($project !== null) {
            $project = "?project={$project}";
        }

        return $this->makeRequest("users/current/stats/{$range}" . $project);
    }

    /**
     * See https://wakatime.com/developers#heartbeats for details.
     *
     * @param  [type] $date
     * @param  string $show
     * @return [type]
     */
    public function heartbeats($date, $show = null)
    {
        if ($show !== null) {
            $show = "?show={$show}";
        }

        return $this->makeRequest("users/current/heartbeats?date={$date}" . $show);
    }

}
