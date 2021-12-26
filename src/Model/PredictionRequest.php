<?php

namespace App\Model;

use App\Entity\City;
use App\Services\Scales\ScaleInterface;

class PredictionRequest
{
    /** @var City */
    private $city;

    /** @var ScaleInterface */
    private $scale;

    /** @var \DateTime */
    private $date;

    /**
     * @return City
     */
    public function getCity(): City
    {
        return $this->city;
    }

    /**
     * @param City $city
     */
    public function setCity(City $city): void
    {
        $this->city = $city;
    }

    /**
     * @return ScaleInterface
     */
    public function getScale(): ScaleInterface
    {
        return $this->scale;
    }

    /**
     * @param ScaleInterface $scale
     */
    public function setScale(ScaleInterface $scale): void
    {
        $this->scale = $scale;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }
}