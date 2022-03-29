<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 */
class Player
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $nickname;

    /**
     * @ORM\OneToMany(targetEntity=Contest::class, mappedBy="winner")
     */
    private $winner_contests;

    /**
     * @ORM\ManyToMany(targetEntity=Contest::class, mappedBy="players")
     */
    private $contests;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="player", cascade={"persist", "remove"})
     */
    private $user;

    public function __construct()
    {
        $this->winner_contests = new ArrayCollection();
        $this->contests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * @return Collection<int, Contest>
     */
    public function getWinnerContests(): Collection
    {
        return $this->winner_contests;
    }

    public function addWinnerContest(Contest $winnerContest): self
    {
        if (!$this->winner_contests->contains($winnerContest)) {
            $this->winner_contests[] = $winnerContest;
            $winnerContest->setWinner($this);
        }

        return $this;
    }

    public function removeWinnerContest(Contest $winnerContest): self
    {
        if ($this->winner_contests->removeElement($winnerContest)) {
            // set the owning side to null (unless already changed)
            if ($winnerContest->getWinner() === $this) {
                $winnerContest->setWinner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contest>
     */
    public function getContests(): Collection
    {
        return $this->contests;
    }

    public function addContest(Contest $contest): self
    {
        if (!$this->contests->contains($contest)) {
            $this->contests[] = $contest;
            $contest->addPlayer($this);
        }

        return $this;
    }

    public function removeContest(Contest $contest): self
    {
        if ($this->contests->removeElement($contest)) {
            $contest->removePlayer($this);
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setPlayer(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getPlayer() !== $this) {
            $user->setPlayer($this);
        }

        $this->user = $user;

        return $this;
    }
}
