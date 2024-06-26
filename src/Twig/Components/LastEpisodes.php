<?php

namespace App\Twig\Components;

use App\Repository\EpisodeRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class LastEpisodes
{
    public function __construct(
        private EpisodeRepository $episodeRepository
    ) {

    }

    public function getLastEpisodes(): array
    {
        return $this->episodeRepository->findBy([], ['id' => 'DESC'], 3);
    }
}
