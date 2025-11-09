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

use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;


class SilverOverdraft implements OverdraftInterface
{
    protected float $overdraftFunds;

    public function __construct( float $limit = 100.00)
    {
        $this->overdraftFunds = $limit;
    }

    public function getOverdraftFundsAmount(): float
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
}
