<?php
namespace App\CustomHelpers\User;
use App\Tenant;
use Carbon\Carbon;

class TenantFilter
{
    /**
    * Get Tenants ordered based on supplied filters.
    *
    * @param   $sortField and $orderBy
    * @return  $Tenants
    */
    public static function getTenantsByOrder( $filters = [] )
    {
       $sortField = 'id'; $sortBy='DESC';

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
 

        return Tenant::orderBy( $sortField, $sortBy )->get();
    }

    /**
     * Get Tenants created on a certain date.
     *
     * @param   $date
     * @return  $Tenants
     */
    public static function getTenantsByDate( $date = null )
    {
      if( $date )

        return Tenant::whereDate('registrationDate',$date)->get();

      else

        return Tenant::all();
    
    }

    /**
      * Get Tenants created during specific dates.
      *
      * @param   $startDate and $endDate
      * @return  $Tenants
      */
      public static function getTenantsBySpecificDate( $filters = [] )
      {
          $startDate = null;
          $endDate = null;
          $sortDateField = 'registrationDate';
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
 


        return Tenant::whereDate( $sortDateField,$operandA,$startDate )->whereDate( $sortDateField,$operandB,$endDate )->get();
      }  
      }  

}