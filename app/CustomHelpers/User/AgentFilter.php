<?php
namespace App\CustomHelpers\User;
use App\Agent;
use Carbon\Carbon;

class AgentFilter
{
    /**
    * Get Agents ordered based on supplied filters.
    *
    * @param   $sortField and $orderBy
    * @return  $Agents
    */
    public static function getAgentsByOrder( $filters = [] )
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
 

        return Agent::orderBy( $sortField, $sortBy )->get();
    }

    /**
     * Get Agents created on a certain date.
     *
     * @param   $date
     * @return  $Agents
     */
    public static function getAgentsByDate( $date = null )
    {
      if( $date )

        return Agent::whereDate('created_at',$date)->get();

      else

        return Agent::all();
    
    }

    /**
      * Get Agents created during specific dates.
      *
      * @param   $startDate and $endDate
      * @return  $Agents
      */
      public static function getAgentsBySpecificDate( $filters = [] )
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
 


        return Agent::whereDate( $sortDateField,$operandA,$startDate )->whereDate( $sortDateField,$operandB,$endDate )->get();
      }  
          
      }  

}