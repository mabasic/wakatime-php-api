<?php namespace Mabasic\WakaTime;

use GuzzleHttp\Client;

class WakaTime {

    protected $guzzle;

    protected $api_key;

    protected $url = 'https://wakatime.com/api/v1';

    public function __construct(Client $guzzle, $api_key = null)
    {
        $this->guzzle = $guzzle;
        $this->api_key = $api_key;
    }

    /**
     * @param mixed $api_key
     * @return $this
     */
    public function setApiKey($api_key)
    {
        $this->api_key = $api_key;

        return $this;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getApiKey()
    {
        if ( ! $this->api_key)
        {
            throw new \Exception('You have to set api_key first!');
        }

        return $this->api_key;
    }

    /**
     * See: https://wakatime.com/api#users-current for details.
     *
     * @return mixed
     */
    public function currentUser()
    {
        return $this->guzzle->get("{$this->url}/users/current?api_key={$this->getApiKey()}")->json();
    }

    /**
     * See: https://wakatime.com/api#summary-daily for details.
     *
     * @param $startDate
     * @param $endDate
     * @param null $project
     * @return mixed
     */
    public function dailySummary($startDate, $endDate, $project = null)
    {
        if ($project !== null) $project = "&project={$project}";

        return $this->guzzle->get("{$this->url}/users/current/summaries?start={$startDate}&end={$endDate}&api_key={$this->getApiKey()}" . $project)->json();
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
    	if ($project !== null) $project = "&project={$project}";

    	return $this->guzzle->get("{$this->url}/users/current/stats/{$range}?api_key={$this->getApiKey()}" . $project)->json();
    }
    
    /**
     * See: https://wakatime.com/developers#heartbeats for details.
     *
     * @param $date
     * @param $show
     * @return mixed
     */
    public function heartbeats($date, $show = null)
    {
        if ($show !== null) $show = "&show={$project}";

        return $this->guzzle->get("{$this->url}/users/current/heartbeats?date={$date}&api_key={$this->getApiKey()}" . $show)->json();
    }

    /**
     * Calculates hours logged for a specific period.
     * You can optionally specify a project.
     *
     * @param $startDate
     * @param $endDate
     * @param null $project
     * @return int
     */
    public function getHoursLoggedFor($startDate, $endDate, $project = null)
    {
        $response = $this->dailySummary($endDate, $startDate, $project);

        return $this->calculateHoursLogged($response);
    }

    /**
     * Calculates hours logged in last xy days, months ...
     * You can optionally specify a project.
     *
     * @param $period
     * @param null $project
     * @return int
     */
    public function getHoursLoggedForLast($period, $project = null)
    {
        $todayDate = date('m/d/Y');
        $endDate = date_format(date_sub(date_create($todayDate), date_interval_create_from_date_string($period)), 'm/d/Y');

        return $this->getHoursLoggedFor($todayDate, $endDate, $project);
    }

    /**
     * Returns hours logged today.
     * You can optionally specify a project.
     *
     * @param null $project
     * @return int
     */
    public function getHoursLoggedForToday($project = null)
    {
        return $this->getHoursLoggedForLast('0 days', $project);
    }

    /**
     * Returns hours logged yesterday.
     * You can optionally specify a project.
     *
     * @param null $project
     * @return int
     */
    public function getHoursLoggedForYesterday($project = null)
    {
        return $this->getHoursLoggedForLast('1 day', $project);
    }

    /**
     * Basic users can only see data for maximum 7 days.
     * Become a Premium user to preserve all data history.
     *
     * _You can still use any method as long as it is under 7 days._
     *
     * @param null $project
     * @return int
     */
    public function getHoursLoggedForLast7Days($project = null)
    {
        return $this->getHoursLoggedForLast('7 days', $project);
    }

    /**
     * Calculates hours logged for last 30 days in history.
     * You can optionally specify a project.
     *
     * @param null $project
     * @return int
     */
    public function getHoursLoggedForLast30Days($project = null)
    {
        return $this->getHoursLoggedForLast('1 month', $project);
    }

    /**
     * Calculates hours logged for this month.
     * You can optionally specify a project.
     *
     * @param null $project
     * @return int
     */
    public function getHoursLoggedForThisMonth($project = null)
    {
        $endDate = date('m/01/Y');
        $startDate = date('m/d/Y');

        return $this->getHoursLoggedFor($startDate, $endDate, $project);
    }

    /**
     * Calculates hours logged for last month.
     * You can optionally specify a project.
     *
     * @param null $project
     * @return int
     */
    public function getHoursLoggedForLastMonth($project = null)
    {
        $endDate = date_format(date_sub(date_create(), date_interval_create_from_date_string('1 month')), 'm/01/Y');
        $startDate = date_format(date_sub(date_create(), date_interval_create_from_date_string('1 month')), 'm/t/Y');

        return $this->getHoursLoggedFor($startDate, $endDate, $project);
    }

    /**
     * Loops through response and sums seconds to calculate hours logged.
     * Converts seconds to hours.
     *
     * @param $response
     * @return int
     */
    private function calculateHoursLogged($response)
    {
        $totalSeconds = 0;

        foreach ($response['data'] as $day)
        {
            $totalSeconds += $day['grand_total']['total_seconds'];
        }

        return (int) floor($totalSeconds / 3600);
    }

}
