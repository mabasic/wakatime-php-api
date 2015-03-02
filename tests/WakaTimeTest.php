<?php

use GuzzleHttp\Client as Guzzle;
use Mabasic\WakaTime\WakaTime;
use webignition\ReadableDuration\ReadableDuration;


class WakaTimeTest extends PHPUnit_Framework_TestCase {

    protected $wakaTime;

    protected $api_key;

    protected $project;

    public function setUp()
    {
        $this->api_key = 'abbfea33-ac43-4492-94a1-693e02271f73';
        $this->project = getenv('WAKATIME_PROJECT');

        // Arrange
        $this->wakaTime = new WakaTime(new Guzzle);
        $this->wakaTime->setApiKey($this->api_key);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_today()
    {
        // Act
        $hours = $this->wakaTime->getHoursLoggedForToday();

        // Assert
        $this->assertInternalType('int', $hours);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_today_for_project()
    {
        // Act
        $hours = $this->wakaTime->getHoursLoggedForToday($this->project);

        // Assert
        $this->assertInternalType('int', $hours);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_yesterday()
    {
        // Act
        $hours = $this->wakaTime->getHoursLoggedForYesterday();

        // Assert
        $this->assertInternalType('int', $hours);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_yesterday_for_project()
    {
        // Act
        $hours = $this->wakaTime->getHoursLoggedForYesterday($this->project);

        // Assert
        $this->assertInternalType('int', $hours);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_last_7_days()
    {
        // Act
        $hours = $this->wakaTime->getHoursLoggedForLast7Days();

        // Assert
        $this->assertInternalType('int', $hours);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_last_7_days_for_project()
    {
        // Act
        $hours = $this->wakaTime->getHoursLoggedForLast7Days($this->project);

        // Assert
        $this->assertInternalType('int', $hours);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_last_30_days()
    {
        // Act
        $hours = $this->wakaTime->getHoursLoggedForLast30Days();

        // Assert
        $this->assertInternalType('int', $hours);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_last_30_days_for_project()
    {
        // Act
        $hours = $this->wakaTime->getHoursLoggedForLast30Days($this->project);

        // Assert
        $this->assertInternalType('int', $hours);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_this_month()
    {
        // Act
        $hours = $this->wakaTime->getHoursLoggedForThisMonth();

        // Assert
        $this->assertInternalType('int', $hours);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_this_month_for_project()
    {
        // Act
        $hours = $this->wakaTime->getHoursLoggedForThisMonth($this->project);

        // Assert
        $this->assertInternalType('int', $hours);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_last_month()
    {
        // Act
        $hours = $this->wakaTime->getHoursLoggedForLastMonth();

        // Assert
        $this->assertInternalType('int', $hours);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_last_month_for_project()
    {
        // Act
        $hours = $this->wakaTime->getHoursLoggedForLastMonth($this->project);

        // Assert
        $this->assertInternalType('int', $hours);
    }

    /** @test */
    public function it_returns_the_currently_logged_in_user()
    {
        $response = $this->wakaTime->currentUser();

        $this->assertInternalType('array', $response);
    }

    /** @test */
    public function it_returns_the_daily_summary_for_period()
    {
        $startDate = '11/21/2014';
        $endDate = '12/21/2014';

        $response = $this->wakaTime->dailySummary($startDate, $endDate);

        $this->assertInternalType('array', $response);
    }

    /** @test */
    public function it_returns_the_daily_summary_for_period_and_project()
    {
        $startDate = '12/19/2014';
        $endDate = '12/20/2014';
        $project = $this->project;

        $response = $this->wakaTime->dailySummary($startDate, $endDate, $project);

        $this->assertInternalType('array', $response);
    }

    /** @test */
    public function it_returns_object_readableduration() {
        $this->wakaTime->setType('object');
        $response = $this->wakaTime->getHoursLoggedForThisMonth();
        $this->assertInstanceOf('ReadableDuration', $response);
    }
}

