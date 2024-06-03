<?php

namespace App\Service;

use App\Entity\Program;
class ProgramDuration
{
    public function calculate(Program $program): string
    {
        $totalDuration = 0;

        //$seasons = $program->getSeasons();
        //var_dump($program->getSeasons());
        //die();
        foreach ($program->getSeasons() as $seasons) {
            foreach ($seasons->getEpisodes() as $episodes) {
                $totalDuration += $episodes->getDuration();
            }
        }

        $totalDuration = $totalDuration / 60;

        return round($totalDuration, 1) . ' heures.';
    }
}