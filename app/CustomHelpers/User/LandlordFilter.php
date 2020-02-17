<?php
namespace App\CustomHelpers\User;
use App\Landlord;
use Carbon\Carbon;

class LandlordFilter
{
    /**
    * Get Landlords ordered based on supplied filters.
    *
    * @param   $sortField and $orderBy
    * @return  $Landlords
    */
    public static function getLandlordsByOrder( $filters = [] )
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
            
        return Landlord::orderBy( $sortField)->get();
    }

    /**
     * Get Landlords created on a certain date.
     *
     * @param   $date
     * @return  $Landlords
     */
    public static function getLandlordsByDate( $date = null )
    {
      if( $date )

        return Landlord::whereDate('created_at',$date)->get();

      else

        return Landlord::all();
    
    }

    /**
      * Get Landlords created during specific dates.
      *
      * @param   $startDate and $endDate
      * @return  $Landlords
      */
      public static function getLandlordsBySpecificDate( $filters = [] )
      {
          $startDate = null;
          $endDate = null;
          $sortDateField = 'created_at';
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
 


        return Landlord::whereDate( $sortDateField,$operandA,$startDate )->whereDate( $sortDateField,$operandB,$endDate )->get();
      }  
          
      }  

}