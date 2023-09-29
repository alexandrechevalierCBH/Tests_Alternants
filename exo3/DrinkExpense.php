<?php

class DrinkExpense
{
    private float $amount;

    private $description;

    private \DateTime $happenedAt;

    private User $le_payeur;

    /**
     * @var array<User>
     */
    private array $participants;

    /**
     * @param array <string, User> $participants
     */
    public function __construct(float $amount, string $description, DateTime $happenedAt, User $le_payeur, array $participants)
    {
        $this->amount = $amount;
        $this->description = $description;
        $this->happenedAt = $happenedAt;
        $this->le_payeur = $le_payeur;
        $this->participants = $participants;
    }


    /**
     * @return array<string, User> $participants
     */
    public function getParticipants(): array
    {
        return $this->participants;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getHappenedAt(): \DateTime
    {
        return $this->happenedAt;
    }

    public function getPayer(): User
    {
        return $this->le_payeur;
    }

    function getType(): string
    {
        return 'DRINK';
    }

    function getUnitaryShared(): float
    {
        return $this->amount / count($this->participants);
    }


    function getUserShare(User $user): float
    {
        // init what was paid and what is due
        $due = 0;
        $paid = 0;

        // if the user is in the participants array, add the unitary share to what is due
        foreach ($this->participants as $participant) {
            if ($participant === $user) {
                $due += $this->getUnitaryShared();
            }
        }

        // if the user is the payer, add the amount to what was paid
        if ($this->le_payeur === $user) {
            $paid += $this->amount;
        }

        // the balance is what was paid - what is due
        return $paid - $due;
    }
}
