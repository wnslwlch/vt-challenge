<?php

namespace App\Service;

use App\Repository\ConfigRepository;
use App\Entity\Config;

class ConfigService
{

    private $configRepository;

    public function __construct(ConfigRepository $configRepository) {
        $this->configRepository = $configRepository;
    }

    public function dateIsOpen(\DateTime $date) {

        $startDate1 = $this->configRepository->findBy(['ckey' => Config::START_DATE_1])[0]->getCvalue();
        $startDate2 = $this->configRepository->findBy(['ckey' => Config::START_DATE_2])[0]->getCvalue();
        $endDate1   = $this->configRepository->findBy(['ckey' => Config::END_DATE_1])[0]->getCvalue();
        $endDate2   = $this->configRepository->findBy(['ckey' => Config::END_DATE_2])[0]->getCvalue();

        $startDate1 = new \DateTime($startDate1);
        $startDate2 = new \DateTime($startDate2);
        $endDate1 = new \DateTime($endDate1);
        $endDate2 = new \DateTime($endDate2);

        $isOpen = false;

        /**
         * First round
         */

        if (
            ($date >= $startDate1 && $date <= $endDate1) ||
            ($date >= $startDate2 && $date <= $endDate2)
        ) {
            $isOpen = true;
        }

        return $isOpen;

    }
}