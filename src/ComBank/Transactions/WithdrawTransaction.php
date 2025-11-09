<?php namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:22 PM
 */

use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class WithdrawTransaction extends BaseTransaction implements BankTransactionInterface
{
  protected float $amount;

  public function __construct(float $amount)
  {
    $this->amount = $amount;
  }

  public function applyTransaction(BankAccountInterface $bankAccount): float
  {
    if ($bankAccount->getBalance() < $this->amount) {
      echo "No tienes fondos suficientes para realizar el retiro.<br>";
    }

    return $bankAccount->getBalance() - $this->amount;
  }
public function getTransactionInfo(): string
  {
    return "Withdrawal of " . $this->amount;
  }

  public function getAmount(): float
  {
    return $this->amount;
  }

}
