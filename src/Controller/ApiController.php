<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Enums\MethodEnum;
use Symfony\Component\HttpFoundation\{Response};
use Symfony\Component\Routing\Attribute\Route;
use App\Service\{ModListService, FibListService};

class ApiController extends AbstractController
{
    public function __construct(
        readonly private ModListService $modListService,
        readonly private FibListService $fibListService,
    ) {}
    
    #[Route('/{userId1}/{userId2}', name: 'list')]
    public function contentList(int $userId1, int $userId2): Response
    {
        if ($userId1 == $userId2) {
            return $this->render('invalid_arg.html.twig');
        }
        return $this->render('list.html.twig', ['list' => $this->fibListService->getList(userId1: $userId1, userId2: $userId2)]);
    }
    
    #[Route('/{userId1}/{userId2}/{method}', name: 'list_with_methode')]
    public function contentListWithMethod(int $userId1, int $userId2, string $method): Response
    {
        if ($userId1 == $userId2) {
            return $this->render('invalid_arg.html.twig');
        }
        $method = MethodEnum::tryFrom($method);
        if ($method == null) {
            return $this->render('invalid_method.html.twig');
        }
        if ($method == MethodEnum::Fib) {
            return $this->render('list.html.twig', ['list' => $this->fibListService->getList(userId1: $userId1, userId2: $userId2)]);
        }
        return $this->render('list.html.twig', ['list' => $this->modListService->getList(userId1: $userId1, userId2: $userId2)]);
    }
    
}
