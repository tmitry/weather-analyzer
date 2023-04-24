<?php

declare(strict_types=1);

namespace App\Temperature\Infrastructure\Controller\Web;

use App\Temperature\Application\Command\CreateAverageTemperature\CreateAverageTemperatureCommand;
use App\Temperature\Application\Command\CreateAverageTemperature\CreateAverageTemperatureCommandHandler;
use App\Temperature\Application\Command\DeleteAverageTemperature\DeleteAverageTemperatureCommandHandler;
use App\Temperature\Application\Command\UpdateAverageTemperature\UpdateAverageTemperatureCommand;
use App\Temperature\Application\Command\UpdateAverageTemperature\UpdateAverageTemperatureCommandHandler;
use App\Temperature\Application\Exception\NotFoundException;
use App\Temperature\Application\Exception\ValidationException;
use App\Temperature\Application\Query\GetAverageTemperature\GetAverageTemperatureQueryHandler;
use App\Temperature\Application\Query\GetAverageTemperatures\GetAverageTemperaturesQueryHandler;
use App\Temperature\Infrastructure\Form\CreateAverageTemperatureCommandType;
use App\Temperature\Infrastructure\Form\UpdateAverageTemperatureCommandType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

#[Route('/temperature/average_temperature')]
class AverageTemperatureController extends AbstractController
{
    #[Route('/', name: 'app_average_temperature_index', methods: ['GET'])]
    public function index(GetAverageTemperaturesQueryHandler $getAverageTemperaturesQueryHandler): Response
    {
        return $this->render('temperature/average_temperature/index.html.twig', [
            'average_temperatures' => $getAverageTemperaturesQueryHandler->execute(),
        ]);
    }

    #[Route('/new', name: 'app_average_temperature_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        CreateAverageTemperatureCommandHandler $createAverageTemperatureCommandHandler
    ): Response {
        $createAverageTemperatureCommand = new CreateAverageTemperatureCommand();
        $form = $this->createForm(CreateAverageTemperatureCommandType::class, $createAverageTemperatureCommand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $createAverageTemperatureCommandHandler->execute($createAverageTemperatureCommand);
            } catch (ValidationException $exception) {
                return $this->render('temperature/average_temperature/validation.html.twig', [
                    'errors' => $exception->getErrors(),
                ]);
            }

            return $this->redirectToRoute('app_average_temperature_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('temperature/average_temperature/new.html.twig', [
            'average_temperature' => $createAverageTemperatureCommand,
            'form'                => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_average_temperature_show', methods: ['GET'])]
    public function show(Uuid $id, GetAverageTemperatureQueryHandler $getAverageTemperatureQueryHandler): Response
    {
        try {
            $averageTemperature = $getAverageTemperatureQueryHandler->execute($id);
        } catch (NotFoundException) {
            throw new NotFoundHttpException();
        }

        return $this->render('temperature/average_temperature/show.html.twig', [
            'average_temperature' => $averageTemperature,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_average_temperature_edit', methods: ['GET', 'POST'])]
    public function edit(
        Uuid $id,
        Request $request,
        UpdateAverageTemperatureCommandHandler $updateAverageTemperatureCommandHandler,
        GetAverageTemperatureQueryHandler $getAverageTemperatureQueryHandler,
    ): Response {
        try {
            $averageTemperature = $getAverageTemperatureQueryHandler->execute($id);
        } catch (NotFoundException) {
            throw new NotFoundHttpException();
        }

        $updateAverageTemperatureCommand = new UpdateAverageTemperatureCommand(
            $averageTemperature->getLocation()->getCountry(),
            $averageTemperature->getLocation()->getCity(),
        );

        $form = $this->createForm(UpdateAverageTemperatureCommandType::class, $updateAverageTemperatureCommand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $updateAverageTemperatureCommandHandler->execute($id, $updateAverageTemperatureCommand);
            } catch (ValidationException $exception) {
                return $this->render('temperature/average_temperature/validation.html.twig', [
                    'errors' => $exception->getErrors(),
                ]);
            } catch (NotFoundException) {
                throw new NotFoundHttpException();
            }

            return $this->redirectToRoute('app_average_temperature_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('temperature/average_temperature/edit.html.twig', [
            'average_temperature' => $updateAverageTemperatureCommand,
            'form'                => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_average_temperature_delete', methods: ['POST'])]
    public function delete(
        Uuid $id,
        Request $request,
        DeleteAverageTemperatureCommandHandler $deleteAverageTemperatureCommandHandler
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $id->toRfc4122(), $request->request->get('_token'))) {
            try {
                $deleteAverageTemperatureCommandHandler->execute($id);
            } catch (NotFoundException) {
                throw new NotFoundHttpException();
            }
        }

        return $this->redirectToRoute('app_average_temperature_index', [], Response::HTTP_SEE_OTHER);
    }
}
