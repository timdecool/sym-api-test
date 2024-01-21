<?php

namespace App\Controller;

use App\Repository\GroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class GroupController extends AbstractController
{
    #[Route('/api/groups', name: 'app_group', methods: ['GET'])]
    public function getGroups(
        GroupRepository $groupRepository,
        SerializerInterface $serializer
    ): JsonResponse
    {
        $groups = $groupRepository->findAll();
        $data = $serializer;
        
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
}
