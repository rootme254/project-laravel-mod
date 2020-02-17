<?php
namespace App\CustomHelpers\Booking;
use App\Listing;
use App\Tenant;
use App\Booking;
use Carbon\Carbon;

class MakeBooking
{
  public static function makeBooking($bookingDetails=[],$tenant=null,$listing=null)
  {
    if( !count($bookingDetails) || is_null($tenant) || is_null($listing) )
      return false;

    $bookingDetails['tenant_id'] = $tenant->id;
    $bookingDetails['listing_id'] = $listing->id;
    $bookingDetails['agent_id'] = $listing->agent_id;

    $booking = Booking::create($bookingDetails);
    return $booking;
  }

  public static function updateBooking($booking=null,$bookingDetails=[],$tenant=null,$listing=null)
  {
    if( is_null($booking) || !count($bookingDetails) || is_null($tenant) || is_null($listing) )
      return false;

    $bookingDetails['tenant_id'] = $tenant->id;
    $bookingDetails['listing_id'] = $listing->id;
    $bookingDetails['agent_id'] = $listing->agent_id;

    $updateState = $booking->update($bookingDetails);

    if( $updateState )
      return $booking;
    else
      return false;
  }
}
