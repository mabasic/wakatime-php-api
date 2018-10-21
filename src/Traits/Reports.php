<?php namespace Mabasic\WakaTime\Traits;

trait Reports {

    /**
     * Calculates hours logged for a specific period.
     * You can optionally specify a project.
     *
     * @param $startDate
     * @param $endDate
     * @param null $project
     * @param null|string $branches
     * @return int
     */
    public function getHoursLoggedFor($startDate, $endDate, $project = null, $branches = null)
    {
        $response = $this->summaries($startDate, $endDate, $project, $branches);

        return $this->calculateHoursLogged($response);
    }

    /**
     * Calculates hours logged in last xy days, months ...
     * You can optionally specify a project.
     *
     * @param $period
     * @param null $project
     * @param null|string $branches
     * @return int
     */
    public function getHoursLoggedForLast($period, $project = null, $branches = null)
    {
        $endDate = date('m/d/Y');
        $startDate   = date_format(date_sub(date_create($endDate), date_interval_create_from_date_string($period)), 'm/d/Y');

        return $this->getHoursLoggedFor($startDate, $endDate, $project, $branches);
    }

    /**
     * Returns hours logged today.
     * You can optionally specify a project.
     *
     * @param null $project
     * @param null|string $branches
     * @return int
     */
    public function getHoursLoggedForToday($project = null, $branches = null)
    {
        return $this->getHoursLoggedForLast('0 days', $project, $branches);
    }

    /**
     * Returns hours logged yesterday.
     * You can optionally specify a project.
     *
     * @param null $project
     * @param null|string $branches
     * @return int
     */
    public function getHoursLoggedForYesterday($project = null, $branches = null)
    {
        return $this->getHoursLoggedForLast('1 day', $project, $branches);
    }

    /**
     * Basic users can only see data for maximum 7 days.
     * Become a Premium user to preserve all data history.
     *
     * _You can still use any method as long as it is under 7 days._
     *
     * @param null $project
     * @param null|string $branches
     * @return int
     */
    public function getHoursLoggedForLast7Days($project = null, $branches = null)
    {
        return $this->getHoursLoggedForLast('7 days', $project, $branches);
    }

    /**
     * Calculates hours logged for last 30 days in history.
     * You can optionally specify a project.
     *
     * @param null $project
     * @param null|string $branches
     * @return int
     */
    public function getHoursLoggedForLast30Days($project = null, $branches = null)
    {
        return $this->getHoursLoggedForLast('1 month', $project, $branches);
    }

    /**
     * Calculates hours logged for this month.
     * You can optionally specify a project.
     *
     * @param null $project
     * @param null|string $branches
     * @return int
     */
    public function getHoursLoggedForThisMonth($project = null, $branches = null)
    {
        $startDate   = date('m/01/Y');
        $endDate = date('m/d/Y');

        return $this->getHoursLoggedFor($startDate, $endDate, $project, $branches);
    }

    /**
     * Calculates hours logged for last month.
     * You can optionally specify a project.
     *
     * @param null $project
     * @param null|string $branches
     * @return int
     */
    public function getHoursLoggedForLastMonth($project = null, $branches = null)
    {
        $startDate   = date_format(date_sub(date_create(), date_interval_create_from_date_string('1 month')), 'm/01/Y');
        $endDate = date_format(date_sub(date_create(), date_interval_create_from_date_string('1 month')), 'm/t/Y');

        return $this->getHoursLoggedFor($startDate, $endDate, $project, $branches);
    }

    /**
     * Loops through response and sums seconds to calculate hours logged.
     * Converts seconds to hours.
     *
     * @param $response
     * @return int
     */
    protected function calculateHoursLogged($response)
    {
        $totalSeconds = 0;

        foreach ($response['data'] as $day) {
            $totalSeconds += $day['grand_total']['total_seconds'];
        }

        return (int) floor($totalSeconds / 3600);
    }

}
