<?php namespace ComBank\Bank;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:25 PM
 */

use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\OverdraftStrategy\NoOverdraft;
use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
use ComBank\Support\Traits\AmountValidationTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use function PHPUnit\Framework\throwException;

class BankAccount implements BankAccountInterface 
{
    private float $balance;
    private string $status;

    // Constructor
    public function __construct(float $initialBalance = 400.0)
    {
        $this->balance = $initialBalance;
        $this->status = 'OPEN';
    }

    public function newB(float $initialBalance = 0.0): void
    {
        $this->balance = $initialBalance;
        $this->status = 'OPEN';
        echo "Nueva cuenta creada con balance:". $this->balance ."€";
    }

    public function isOpen(): bool
    {
        if ($this->status === 'OPEN') {
            return true;
        }
        else {
            return false;
        }
    }
    
    public function closeAccount(): void
    {
        if ($this->status === 'CLOSED') {
            throw new BankAccountException("La cuenta ya está cerrada.");
        }
        $this->status = 'CLOSED';
    }
    
    public function reopenAccount(): void
    {
        if ($this->status === 'OPEN') {
            throw new BankAccountException("La cuenta ya está abierta.");
        }else{
            $this->status = 'OPEN';
        }
    }

    
    public function getBalance(): float
    {
        return $this->balance;
    }

    public function setBalance(float $newBalance): void
    {
        $this->balance = $newBalance;
    }

    public function transaction(BankTransactionInterface $bankTransaction) : void
    {
        if ($this->status !='OPEN'){
        }
        // la cuenta no puede quedar en negativo 

        if ($this->balance < $bankTransaction->getAmount()) {
            echo "Fondos insuficientes para la transacción.";
        }
        else {
            try {
                $newBalance = $bankTransaction->applyTransaction($this);
                $this->setBalance($newBalance);
            }catch (InvalidOverdraftFundsException $e) {
                throw new FailedTransactionException("Transacción fallida: " . $e->getMessage());
            }
        }
    }
}
