<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\CustomHelpers\User\UserFilter;
use Carbon\Carbon;

class FilterUsersTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_filter_users_ascending()
    {
        factory(User::class,10)->create();
        $foundUsers = UserFilter::getUsersByOrder(['sortField'=>'id','orderBy' => 'ASC']);
        $retrivedUsers = User::all();
        $this->assertEquals($foundUsers[0]['id'],$retrivedUsers[0]['id']);
        $this->assertEquals(count($foundUsers),10);
    }

    public function test_can_filter_users_decending()
    {
        factory(User::class,10)->create();
        $foundUsers = UserFilter::getUsersByOrder(['sortField'=>'id','orderBy' => 'DESC']);
        $retrivedUsers = User::all();
        $this->assertEquals($foundUsers[0]['id'],$retrivedUsers[9]['id']);
        $this->assertEquals(count($foundUsers),10);
    }

    public function test_can_filter_users_by_date()
    {
        factory(User::class)->create(['firstName'=>'Created today','created_at' => Carbon::today()]);
        factory(User::class)->create(['firstName'=>'Created yesterday','created_at' => Carbon::yesterday()]);

        $foundUsers = UserFilter::getUsersByDate( Carbon::today() );

        $this->assertEquals(count($foundUsers),1);
        $this->assertEquals($foundUsers[0]['firstName'], 'Created today');
    }

    public function test_can_filter_users_created_in_specific_dates()
    {
        factory(User::class,2)->create(['firstName'=>'Created today','created_at' => Carbon::today()]);
        factory(User::class,2)->create(['firstName'=>'Created yesterday','created_at' => Carbon::yesterday()]);
        factory(User::class,10)->create(['firstName'=>'Created yesterday','created_at' => Carbon::tomorrow()]);
        $foundUsers = UserFilter::getUsersBySpecificDate( ['startDate'=>Carbon::yesterday(), 'endDate'=>Carbon::today()] );

        $this->assertEquals(count($foundUsers),4);
    }
}
