<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Listing;
use App\CustomHelpers\Listing\ListingFilters;
use Carbon\Carbon;

class FilterListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_filter_listings_ascending()
    {
        factory(Listing::class,10)->create();
        factory(Listing::class,10)->create(['live'=>null]);
        $foundListings = ListingFilters::getListingsByOrder(['sortField'=>'id','orderBy' => 'ASC']);
        $retrivedListings = Listing::where('live',1)->get();
        $this->assertEquals($foundListings[0]['id'],$retrivedListings[0]['id']);
        $this->assertEquals(count($foundListings),10);
    }

    public function test_can_filter_listings_with_pending_ascending()
    {
        factory(Listing::class,10)->create();
        factory(Listing::class,10)->create(['live'=>null]);
        $foundListings = ListingFilters::getListingswithPendingByOrder(['sortField'=>'id','orderBy' => 'ASC']);
        $retrivedListings = Listing::all();
        $this->assertEquals($foundListings[0]['id'],$retrivedListings[0]['id']);
        $this->assertEquals(count($foundListings),20);
    }

    public function test_can_filter_pending_listings_ascending()
    {
        factory(Listing::class,10)->create();
        factory(Listing::class,10)->create(['live'=>null]);
        $foundListings = ListingFilters::getPendingListingsByOrder(['sortField'=>'id','orderBy' => 'ASC']);
        $retrivedListings = Listing::where('live',null)->get();
        $this->assertEquals($foundListings[0]['id'],$retrivedListings[0]['id']);
        $this->assertEquals(count($foundListings),10);
    }

    public function test_can_filter_listings_descending()
    {
        factory(Listing::class,10)->create();
        factory(Listing::class,10)->create(['live'=>null]);
        $foundListings = ListingFilters::getListingsByOrder(['orderBy' => 'DESC']);
        $retrivedListings = Listing::all();
        $this->assertEquals($foundListings[0]['id'],$retrivedListings[9]['id']);
        $this->assertEquals(count($foundListings),10);
    }

    public function test_can_filter_listings_with_pending_descending()
    {
        factory(Listing::class,10)->create();
        factory(Listing::class,10)->create(['live'=>null]);
        $foundListings = ListingFilters::getListingswithPendingByOrder(['orderBy' => 'DESC']);
        $retrivedListings = Listing::all();
        $this->assertEquals($foundListings[0]['id'],$retrivedListings[19]['id']);
        $this->assertEquals(count($foundListings),20);
    }

    public function test_can_filter_pending_listings_descending()
    {
        factory(Listing::class,10)->create();
        factory(Listing::class,10)->create(['live'=>null]);
        $foundListings = ListingFilters::getPendingListingsByOrder(['orderBy' => 'DESC']);
        $retrivedListings = Listing::where('live',null)->get();
        $this->assertEquals($foundListings[0]['id'],$retrivedListings[9]['id']);
        $this->assertEquals(count($foundListings),10);
    }

    public function test_can_filter_listings_date()
    {
        factory(Listing::class)->create(['title'=>'Created today','created_at' => Carbon::today()]);
        factory(Listing::class)->create(['title'=>'Created today','created_at' => Carbon::today(),'live'=>null]);
        factory(Listing::class)->create(['title'=>'Created yesterday','created_at' => Carbon::yesterday()]);

        $foundListings = ListingFilters::getListingsByDate( Carbon::today() );

        $this->assertEquals(count($foundListings),1);
        $this->assertEquals($foundListings[0]['title'], 'Created today');
    }

    public function test_can_filter_listings_with_pending_date()
    {
        factory(Listing::class)->create(['title'=>'Created today','created_at' => Carbon::today()]);
        factory(Listing::class)->create(['title'=>'Created today but pending','created_at' => Carbon::today(),'live'=>null]);
        factory(Listing::class)->create(['title'=>'Created yesterday','created_at' => Carbon::yesterday()]);
        $foundListings = ListingFilters::getListingsWithPendingByDate( Carbon::today() );

        $this->assertEquals(count($foundListings),2);
        $this->assertEquals($foundListings[1]['title'], 'Created today but pending');
    }


    public function test_can_filter_pending_listings_date()
    {
        factory(Listing::class)->create(['title'=>'Created today','created_at' => Carbon::today()]);
        factory(Listing::class)->create(['title'=>'Created today but pending','created_at' => Carbon::today(),'live'=>null]);
        factory(Listing::class)->create(['title'=>'Created yesterday','created_at' => Carbon::yesterday()]);
        $foundListings = ListingFilters::getPendingListingsByDate( Carbon::today() );

        $this->assertEquals(count($foundListings),1);
        $this->assertEquals($foundListings[0]['title'], 'Created today but pending');
    }

    public function test_can_filter_listings_in_specific_dates()
    {
        factory(Listing::class,2)->create(['title'=>'Created today','created_at' => Carbon::today()]);
        factory(Listing::class,2)->create(['title'=>'Created yesterday','created_at' => Carbon::yesterday()]);
        factory(Listing::class,2)->create(['title'=>'Created today','created_at' => Carbon::today(),'live'=>null]);
        factory(Listing::class,2)->create(['title'=>'Created yesterday','created_at' => Carbon::yesterday(),'live'=>null]);
        factory(Listing::class,10)->create(['title'=>'Created yesterday','created_at' => Carbon::tomorrow()]);
        $foundListings = ListingFilters::getListingsBySpecificDate( ['startDate'=>Carbon::yesterday(), 'endDate'=>Carbon::today()] );

        $this->assertEquals(count($foundListings),4);
    }

    public function test_can_filter_listings_with_pending_in_specific_dates()
    {
        factory(Listing::class,2)->create(['title'=>'Created today','created_at' => Carbon::today()]);
        factory(Listing::class,2)->create(['title'=>'Created yesterday','created_at' => Carbon::yesterday()]);
        factory(Listing::class,2)->create(['title'=>'Created today','created_at' => Carbon::today(),'live'=>null]);
        factory(Listing::class,2)->create(['title'=>'Created yesterday','created_at' => Carbon::yesterday(),'live'=>null]);
        factory(Listing::class,10)->create(['title'=>'Created yesterday','created_at' => Carbon::tomorrow()]);
        $foundListings = ListingFilters::getListingsWithPendingBySpecificDate( ['startDate'=>Carbon::yesterday(), 'endDate'=>Carbon::today()] );

        $this->assertEquals(count($foundListings),8);
    }

    public function test_can_filter_pending_listings_in_specific_dates()
    {
        factory(Listing::class,2)->create(['title'=>'Created today','created_at' => Carbon::today()]);
        factory(Listing::class,2)->create(['title'=>'Created yesterday','created_at' => Carbon::yesterday()]);
        factory(Listing::class,2)->create(['title'=>'Created today','created_at' => Carbon::today(),'live'=>null]);
        factory(Listing::class,2)->create(['title'=>'Created yesterday','created_at' => Carbon::yesterday(),'live'=>null]);
        factory(Listing::class,10)->create(['title'=>'Created yesterday','created_at' => Carbon::tomorrow()]);
        $foundListings = ListingFilters::getPendingListingsBySpecificDate( ['startDate'=>Carbon::yesterday(), 'endDate'=>Carbon::today()] );

        $this->assertEquals(count($foundListings),4);
    }

    public function test_can_filter_listing_using_custom_filters()
    {
        factory(Listing::class,2)->create(['title'=>'Created today','created_at' => Carbon::today()]);
        factory(Listing::class,2)->create(['title'=>'Created yesterday','created_at' => Carbon::yesterday()]);
        factory(Listing::class,2)->create(['title'=>'Created today','created_at' => Carbon::today(),'live'=>null]);
        factory(Listing::class,2)->create(['title'=>'Created yesterday','created_at' => Carbon::yesterday(),'live'=>null]);
        factory(Listing::class,10)->create(['title'=>'Created yesterday','created_at' => Carbon::tomorrow()]);
        $filters = [
          'orderBy' => 'DESC',
          'sortField' => 'id',
          'startDate' => Carbon::yesterday(),
          'endDate' => Carbon::today(),
        ];
        $foundListings = ListingFilters::getListings( $filters );

        $retrivedListings = Listing::where('live',1)->whereDate('created_at','>=',Carbon::yesterday())->whereDate('created_at','<=',Carbon::today())->get();
        $this->assertEquals(count($foundListings),4);
        $this->assertEquals($foundListings[0]['id'],$retrivedListings[3]['id']);
    }

    public function test_can_filter_listing_with_pending_using_custom_filters()
    {
        factory(Listing::class,2)->create(['title'=>'Created today','created_at' => Carbon::today()]);
        factory(Listing::class,2)->create(['title'=>'Created yesterday','created_at' => Carbon::yesterday()]);
        factory(Listing::class,2)->create(['title'=>'Created today','created_at' => Carbon::today(),'live'=>null]);
        factory(Listing::class,2)->create(['title'=>'Created yesterday','created_at' => Carbon::yesterday(),'live'=>null]);
        factory(Listing::class,10)->create(['title'=>'Created yesterday','created_at' => Carbon::tomorrow()]);
        $filters = [
          'orderBy' => 'DESC',
          'sortField' => 'id',
          'startDate' => Carbon::yesterday(),
          'endDate' => Carbon::today(),
        ];
        $foundListings = ListingFilters::getListingsWithPending( $filters );

        $retrivedListings = Listing::whereDate('created_at','>=',Carbon::yesterday())->whereDate('created_at','<=',Carbon::today())->get();
        $this->assertEquals(count($foundListings),8);
        $this->assertEquals($foundListings[0]['id'],$retrivedListings[7]['id']);
    }

    public function test_can_filter_pending_listing_using_custom_filters()
    {
        factory(Listing::class,2)->create(['title'=>'Created today','created_at' => Carbon::today()]);
        factory(Listing::class,2)->create(['title'=>'Created yesterday','created_at' => Carbon::yesterday()]);
        factory(Listing::class,2)->create(['title'=>'Created today','created_at' => Carbon::today(),'live'=>null]);
        factory(Listing::class,2)->create(['title'=>'Created yesterday','created_at' => Carbon::yesterday(),'live'=>null]);
        factory(Listing::class,10)->create(['title'=>'Created yesterday','created_at' => Carbon::tomorrow()]);
        $filters = [
          'orderBy' => 'DESC',
          'sortField' => 'id',
          'startDate' => Carbon::yesterday(),
          'endDate' => Carbon::today(),
        ];
        $foundListings = ListingFilters::getPendingListings( $filters );

        $retrivedListings = Listing::where('live',null)->whereDate('created_at','>=',Carbon::yesterday())->whereDate('created_at','<=',Carbon::today())->get();
        $this->assertEquals(count($foundListings),4);
        $this->assertEquals($foundListings[0]['id'],$retrivedListings[3]['id']);
    }
}
