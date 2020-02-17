<?php
namespace App\CustomHelpers\User;
use App\User;
use Carbon\Carbon;

class UserFilter
{
    /**
    * Get users ordered based on supplied filters.
    *
    * @param   $sortField and $orderBy
    * @return  $users
    */
    public static function getUsersByOrder( $filters = [] )
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
 

        return User::orderBy( $sortField, $sortBy )->get();
    }

    /**
     * Get users created on a certain date.
     *
     * @param   $date
     * @return  $users
     */
    public static function getUsersByDate( $date = null )
    {
      if( $date )
        return User::whereDate('created_at',$date)->get();
      else
        return User::all();
    }

    /**
      * Get users created during specific dates.
      *
      * @param   $startDate and $endDate
      * @return  $users
      */
      public static function getUsersBySpecificDate( $filters = [] )
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
 


        return User::whereDate( $sortDateField,$operandA,$startDate )->whereDate( $sortDateField,$operandB,$endDate )->get();
      }  

      
    
}
