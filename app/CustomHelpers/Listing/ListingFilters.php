<?php
namespace App\CustomHelpers\Listing;
use App\Listing;
use Carbon\Carbon;

class ListingFilters
{
    protected static $sortDatesByField = 'created_at';
   /**
    * Get live listings ordered based on supplied filters.
    *
    * @param   $sortField and $orderBy
    * @return  $listings
    */
    public static function getListingsByOrder( $filters = [] )
    {
        $values = self::getOrderByVariables( $filters );
        return Listing::where('live',1)->orderBy( $values['sortField'], $values['orderBy'] )->get();
    }

    /**
     * Get listings with pending ordered based on supplied filters.
     *
     * @param   $sortField and $orderBy
     * @return  $listings
     */
     public static function getListingswithPendingByOrder( $filters = [] )
     {
         $values = self::getOrderByVariables( $filters );
         return Listing::orderBy( $values['sortField'], $values['orderBy'] )->get();
     }

     /**
      * Get pending listings ordered based on supplied filters.
      *
      * @param   $sortField and $orderBy
      * @return  $listings
      */
      public static function getPendingListingsByOrder( $filters = [] )
      {
          $values = self::getOrderByVariables( $filters );
          return Listing::where('live',null)->orderBy( $values['sortField'], $values['orderBy'] )->get();
      }

    /**
     * Get live listings created certain date.
     *
     * @param   $date
     * @return  $listings
     */
     public static function getListingsByDate( $date = null )
     {
       if( $date )
         return Listing::where('live',1)->whereDate('created_at',$date)->get();
       else
         return Listing::where('live',1)->gets();
     }

     /**
      * Get listings with pending created certain date.
      *
      * @param   $date
      * @return  $listings
      */
      public static function getListingsWithPendingByDate( $date = null )
      {
        if( $date )
          return Listing::whereDate('created_at',$date)->get();
        else
          return Listing::all();
      }

      /**
       * Get pending listings  created certain date.
       *
       * @param   $date
       * @return  $listings
       */
       public static function getPendingListingsByDate( $date = null )
       {
         if( $date )
           return Listing::where('live',null)->whereDate('created_at',$date)->get();
         else
           return Listing::where('live',null)->get();
       }


     /**
      * Get listings created during specific dates.
      *
      * @param   $startDate and $endDate
      * @return  $listings
      */
      public static function getListingsBySpecificDate( $filters = [] )
      {
        $values = self::getListingSpecifiedDatesVariables( $filters );
        return Listing::where('live',1)->whereDate( $values['sortDateField'],$values['operandA'],$values['startDate'] )->whereDate( $values['sortDateField'],$values['operandB'],$values['endDate'] )->get();
      }

      /**
       * Get listings with pending created during specific dates.
       *
       * @param   $startDate and $endDate
       * @return  $listings
       */
       public static function getListingsWithPendingBySpecificDate( $filters = [] )
       {
         $values = self::getListingSpecifiedDatesVariables( $filters );
         return Listing::whereDate( $values['sortDateField'],$values['operandA'],$values['startDate'] )->whereDate( $values['sortDateField'],$values['operandB'],$values['endDate'] )->get();
       }

       /**
        * Get pending listings created during specific dates.
        *
        * @param   $startDate and $endDate
        * @return  $listings
        */
        public static function getPendingListingsBySpecificDate( $filters = [] )
        {
          $values = self::getListingSpecifiedDatesVariables( $filters );
          return Listing::where('live',null)->whereDate( $values['sortDateField'],$values['operandA'],$values['startDate'] )->whereDate( $values['sortDateField'],$values['operandB'],$values['endDate'] )->get();
        }

      /**
       * Get listings based on supplied filters.
       *
       * @param  array $filters
       * @return array $listings
       */
       public static function getListings( $filters = [] )
       {
         $orderValues = self::getOrderByVariables( $filters );
         $dateValues = self::getListingSpecifiedDatesVariables( $filters );
         return Listing::orderBy( $orderValues['sortField'], $orderValues['orderBy'] )
                        ->where( $dateValues['sortDateField'],$dateValues['operandA'],$dateValues['startDate'] )
                        ->where( $dateValues['sortDateField'],$dateValues['operandB'],$dateValues['endDate'] )
                        ->where('live',1)
                        ->get();
       }

       /**
        * Get listings with pending based on supplied filters.
        *
        * @param  array $filters
        * @return array $listings
        */
        public static function getListingsWithPending( $filters = [] )
        {
          $orderValues = self::getOrderByVariables( $filters );
          $dateValues = self::getListingSpecifiedDatesVariables( $filters );
          return Listing::orderBy( $orderValues['sortField'], $orderValues['orderBy'] )
                         ->where( $dateValues['sortDateField'],$dateValues['operandA'],$dateValues['startDate'] )
                         ->where( $dateValues['sortDateField'],$dateValues['operandB'],$dateValues['endDate'] )
                         ->get();
        }

        /**
         * Get listings based on supplied filters.
         *
         * @param  array $filters
         * @return array $listings
         */
         public static function getPendingListings( $filters = [] )
         {
           $orderValues = self::getOrderByVariables( $filters );
           $dateValues = self::getListingSpecifiedDatesVariables( $filters );
           return Listing::orderBy( $orderValues['sortField'], $orderValues['orderBy'] )
                          ->where( $dateValues['sortDateField'],$dateValues['operandA'],$dateValues['startDate'] )
                          ->where( $dateValues['sortDateField'],$dateValues['operandB'],$dateValues['endDate'] )
                          ->where('live',null)
                          ->get();
         }

       /**
        * Get fields to sort listing.
        *
        * @param  array $filters
        * @return array $filters
        */
       protected static function getOrderByVariables( $filters = [] )
       {
         $sortField = 'id';$sortBy='DESC';
         if( isset($filters['sortField']) && isset($filters['orderBy']) )
         {
           $sortField = $filters['sortField'];
           $sortBy=$filters['orderBy'];
         }

         elseif( !isset($filters['sortField']) && isset($filters['orderBy']) )
         {
           $sortBy=$filters['orderBy'];
         }


         elseif( isset($filters['sortField']) && !isset($filters['orderBy']) )
         {
           $sortField = $filters['sortField'];
         }

         $filters['sortField'] = $sortField;
         $filters['orderBy'] = $sortBy;

         return $filters;

       }


       /**
        * Get fields to sort listing.
        *
        * @param  array $filters
        * @return array $filters
        */
       protected static function getListingSpecifiedDatesVariables( $filters = [] )
       {
         $startDate = null;
         $endDate = null;
         $sortDateField = self::$sortDatesByField;
         $operandA = '<>';
         $operandB = '<>';

         if( isset($filters['startDate']) && isset($filters['endDate']) )
         {
           $startDate = $filters['startDate'];
           $endDate = $filters['endDate'];
           $operandA = '>=';
           $operandB = '<=';
         }

         elseif( !isset($filters['startDate']) && isset($filters['endDate']) )
         {
           $endDate = $filters['endDate'];
           $operandB = '<=';
         }


         elseif( isset($filters['startDate']) && !isset($filters['endDate']) )
         {
           $startDate = $filters['startDate'];
           $operandA = '>=';
         }

         $filters['startDate'] = $startDate;
         $filters['endDate'] = $endDate;
         $filters['operandA'] = $operandA;
         $filters['operandB'] = $operandB;
         $filters['sortDateField'] = $sortDateField;

         return $filters;

       }
}
