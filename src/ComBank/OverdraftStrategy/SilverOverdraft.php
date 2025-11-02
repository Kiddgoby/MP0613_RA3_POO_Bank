<?php namespace ComBank\OverdraftStrategy;
 
/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:39 PM
 */
 
/**
 * @description: Grant 100.00 overdraft funds.
 * */
class SilverOverdraft
{
    protected float $overdraftFunds;
 
    public function __construct(float $overdraftFunds = 100.0)
    {
        $this->overdraftFunds = $overdraftFunds;
    }
 
    public function getOverdraftFunds(): float
    {
        return $this->overdraftFunds;
    }
    public function isGrantOverdraftFunds(float $newAmount): bool
    {
        if ($newAmount >= -$this->overdraftFunds) {
            return true;
        }
        return false;
    }    
    public function applyOverdraft(): float
    {
        return $this->overdraftFunds;
    }
    
  
}
