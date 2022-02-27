<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Day::class, inversedBy: 'schedules')]
    #[ORM\JoinColumn(nullable: false)]
    private $day;

    #[ORM\ManyToOne(targetEntity: Subject::class, inversedBy: 'schedules')]
    #[ORM\JoinColumn(nullable: false)]
    private $subject;

    #[ORM\ManyToOne(targetEntity: Period::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $period;

    #[ORM\Column(type: 'boolean')]
    private $isOdd;

    #[ORM\OneToMany(mappedBy: 'schedule_id', targetEntity: Attendance::class, orphanRemoval: true)]
    private $attendances;

    public function __construct()
    {
        $this->attendances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDayId(): ?Day
    {
        return $this->day_id;
    }

    public function setDayId(?Day $day_id): self
    {
        $this->day_id = $day_id;

        return $this;
    }

    public function getSubjectId(): ?Subject
    {
        return $this->subject_id;
    }

    public function setSubjectId(?Subject $subject_id): self
    {
        $this->subject_id = $subject_id;

        return $this;
    }

    public function getPeriodId(): ?Period
    {
        return $this->period_id;
    }

    public function setPeriodId(?Period $period_id): self
    {
        $this->period_id = $period_id;

        return $this;
    }

    public function getIsOdd(): ?bool
    {
        return $this->isOdd;
    }

    public function setIsOdd(bool $isOdd): self
    {
        $this->isOdd = $isOdd;

        return $this;
    }

    /**
     * @return Collection<int, Attendance>
     */
    public function getAttendances(): Collection
    {
        return $this->attendances;
    }

    public function addAttendance(Attendance $attendance): self
    {
        if (!$this->attendances->contains($attendance)) {
            $this->attendances[] = $attendance;
            $attendance->setScheduleId($this);
        }

        return $this;
    }

    public function removeAttendance(Attendance $attendance): self
    {
        if ($this->attendances->removeElement($attendance)) {
            // set the owning side to null (unless already changed)
            if ($attendance->getScheduleId() === $this) {
                $attendance->setScheduleId(null);
            }
        }

        return $this;
    }
}
