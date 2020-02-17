<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\CustomHelpers\Booking\MakeBooking as Booking;
use Tests\TestCase;
use App\Tenant;
use App\Listing;
use Carbon\Carbon;

class MakeBooking extends TestCase
{
    use RefreshDatabase;

    public function test_tenant_can_make_a_booking()
    {
      $tenant = factory(Tenant::class)->create(['occupation'=>'Teacher']);
      $listing = factory(Listing::class)->create();

      $bookingDetails = [
        'pickupLocation' => 'Tumaini',
        'pickupDate' => Carbon::tomorrow(),
        'instruction' => 'Be the very early',
      ];

      $booking = Booking::makeBooking($bookingDetails,$tenant,$listing);

      $this->assertEquals(!is_null($booking),count($tenant->booking));
      $this->assertEquals($booking['pickupLocation'],$tenant->booking[0]->pickupLocation);
    }

    public function test_tenant_can_update_a_booking()
    {
      $tenant = factory(Tenant::class)->create(['occupation'=>'Teacher']);
      $listing = factory(Listing::class)->create();

      $bookingDetails = [
        'pickupLocation' => 'Tumaini',
        'pickupDate' => Carbon::tomorrow(),
        'instruction' => 'Be the very early',
      ];

      $booking = Booking::makeBooking($bookingDetails,$tenant,$listing);

      $updatedBookingDetails = [
        'pickupLocation' => 'ACK',
        'pickupDate' => Carbon::tomorrow(),
      ];

      $updatedBooking = Booking::updateBooking($booking,$updatedBookingDetails,$tenant,$listing);

      $this->assertEquals($updatedBooking->id,$booking->id);
      $this->assertEquals($updatedBooking['pickupLocation'],'ACK');
    }
}
