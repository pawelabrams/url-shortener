<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ShortenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Redirect extends AbstractController
{
    public function __construct(
        public ShortenRepository $shortenRepository,
    ) {
    }

    #[Route('/{shorten_id}', name: 'redirect')]
    public function __invoke(string $shorten_id): Response
    {
        $shorten = $this->shortenRepository->find($shorten_id);

        if (null === $shorten) {
            return $this->redirect('/404', Response::HTTP_TEMPORARY_REDIRECT);
        }

        // TODO: consider moving this to an event listener; there might be more analytics data to gather here
        $this->shortenRepository->incrementVisitors($shorten_id);

        return $this->redirect($shorten->url, Response::HTTP_PERMANENTLY_REDIRECT);
    }
}
