<?php

declare(strict_types=1);


class BankAccount
{
    protected int $balance;

    public function __construct(int $balance = 0)
    {
        if ($balance < 0) {
            $this->balance = 0;
            die('Balance cannot be less than 0');
        }
        $this->balance = $balance;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }

    public function spend(int $amount): void
    {
        if ($amount > $this->balance) {
            die('Cannot spend more than you have');
        }

        if ($amount <= 0) {
            die('Can only spend a positive amount');
        }

        $this->balance = $this->balance - $amount;
    }

    public function deposit(int $amount): void
    {
        $amount = $this->applyFees($amount);

        if ($amount > 0) {
            $this->balance = $this->balance + $amount;
        }
    }

    protected function applyFees(int $amount): int
    {
        return (int)round($amount - $amount * 0.01);
    }
}

$account = new BankAccount(1000);
$account->deposit(1000);
//echo $account->getBalance();$account->spend(100);
$account->spend(100);
$account->spend(100);
$account->spend(100);
echo PHP_EOL;
//echo $account->getBalance();

/*
Sukurkite išvestines klases, kurios paveldėtų klasę BankAccount:
- klasė StudentAccount - Ši klasė turi netaikyti jokių mokesčių depozitams.

- klasė ChildAccount - Ši klasė neturi leisti per vieną kartą išleisti daugiau nei 10eur.

- klasė CreditAccount - Ši klasė turi leisti balansui nukristi iki -X sumos ($maxCreditAmount).
T.y. balansas gali buti neigiamas. $maxCreditAmount yra teigiama integer tipo reikšmė.
Jeigu $maxCreditAmount yra 100, tai reiškia, kad balansas negali kristi žemiau -100.
Ši suma ($maxCreditAmount) turi būti paduodama per konstruktorių.
Pavyzdys:
$account = new CreditAccount(1000, 100);

- klasė SavingsAccount. Ši klasė turi suteikti galimybę padidinti sąskaitos balansą tam tikru procentu.
T.y. - ji gali turėti public metodą 'addInterest', kurį iškvietus su X procentu (pvz.: 0.05), balansas padidėtų tuo procentu
Įsivaizduokite, kad šis metodas būtų kviečiamas kas metus ir sąskaita tokiu būdu augtų.
Prie balanso pridedamas palūkanas verskite į int tipą.
Pavyzdys:
$account = new SavingsAccount(1000);
$account->addInterest(0.05);
*/

class StudentAccount extends BankAccount
{

    protected function applyFees(int $amount): int
    {
        return $amount;
    }
}

$studentAccount = new StudentAccount(1000);
$studentAccount->deposit(1000);

//echo $studentAccount->getBalance();

class ChildAccount extends BankAccount
{

    public function spend(int $amount): void
    {
        if ($amount > 10) {
            die('Cannot spend more than 10 eur');
        }
        parent::spend($amount);

    }
}

$childAccount = new ChildAccount(1000);
$childAccount->spend(9);
//echo $childAccount->getBalance();

/*
 - klasė CreditAccount - Ši klasė turi leisti balansui nukristi iki -X sumos ($maxCreditAmount).
T.y. balansas gali buti neigiamas. $maxCreditAmount yra teigiama integer tipo reikšmė.
Jeigu $maxCreditAmount yra 100, tai reiškia, kad balansas negali kristi žemiau -100.
Ši suma ($maxCreditAmount) turi būti paduodama per konstruktorių.
Pavyzdys:
$account = new CreditAccount(1000, 100);
 */

class CreditAccount extends BankAccount
{
    public function __construct(protected int $balance = 0, private int $maxCreditAmount = 0)
    {
        if ($balance < $maxCreditAmount * -1) {
            die('Cannot create account with balance below credit amount ' . $this->maxCreditAmount);
        }
    }

    public function spend(int $amount): void
    {
        if ($amount > $this->balance + $this->maxCreditAmount) {
            die('Credit amount exceeded. Your credit is ' . $this->maxCreditAmount);
        }

        if ($amount <= 0) {
            die('Can only spend a positive amount');
        }

        $this->balance = $this->balance - $amount;
    }
}

$creditAccount = new CreditAccount(-5, 5);
$creditAccount->deposit(5);
//while (true) {
//    $creditAccount->spend(1);
//    echo 'Balance: ' . $creditAccount->getBalance() . PHP_EOL;
//    sleep(1);
//}

/*
 - klasė SavingsAccount. Ši klasė turi suteikti galimybę padidinti sąskaitos balansą tam tikru procentu.
T.y. - ji gali turėti public metodą 'addInterest', kurį iškvietus su X procentu (pvz.: 0.05), balansas padidėtų tuo procentu
Įsivaizduokite, kad šis metodas būtų kviečiamas kas metus ir sąskaita tokiu būdu augtų.
Prie balanso pridedamas palūkanas verskite į int tipą.
Pavyzdys:
$account = new SavingsAccount(1000);
$account->addInterest(0.05);
 */

class SavingsAccount extends BankAccount
{
    public function addInterest(float $percent): void
    {
        $this->balance += (int)($this->balance * $percent);
    }
}

$savingsAccount = new SavingsAccount(1000);
$savingsAccount->addInterest(0.05);
echo $savingsAccount->getBalance(); // 1050;

/*
- BudgetingAccount. Šis sąskaitos tipas turi leisti nustatyti sumą, kuri keliaus į atskirą biudzetą nuo kiekvieno depozito.
Pvz.: klientas taupo automobiliui. Klientas nusprendžia, kad 10% nuo kiekvieno depozito keliaus i automobilio pirkimo
biudžetą. (procentas paduodamas per konstruktorių).
Įprastiniai banko depozito mokesčiai nėra taikomi tai daliai, kuri keliauja į taupymo biudžetą.
Pridėkite metodą getBudget(), kuris parodytų, kiek šiuo metu yra sukaupta taupymo biudzetui.
 */

class BudgetingAccount extends BankAccount
{
    private int $budget = 0;

    public function __construct(int $balance = 0, private float $budgetingPercent)
    {
        parent::__construct($balance);
    }

    public function deposit(int $amount): void
    {
        $budgetingAmount = (int)($this->budgetingPercent * $amount);
        $this->budget += $budgetingAmount;
        parent::deposit($amount - $budgetingAmount);
    }

    public function getBudget(): int
    {
        return $this->budget;
    }
}

$b = new BudgetingAccount(1000, 0.1);
$b->deposit(1000);
echo 'Balance: ' . $b->getBalance() . PHP_EOL;
echo 'Budget: ' . $b->getBudget() . PHP_EOL;
$b->deposit(1000);
echo 'Balance: ' . $b->getBalance() . PHP_EOL;
echo 'Budget: ' . $b->getBudget() . PHP_EOL;