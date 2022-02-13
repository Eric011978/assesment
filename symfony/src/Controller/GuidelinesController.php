<?php

namespace App\Controller;

use App\Entity\Guideline;
use App\Repository\GuidelineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GuidelinesController extends AbstractController
{
    public function index(GuidelineRepository $guidelineRepository)
    {
        return $this->render('guidelines.html.twig', [
            'guidelines' => $guidelineRepository->findAllWithGuidelineNavigations(),
        ]);
    }
}