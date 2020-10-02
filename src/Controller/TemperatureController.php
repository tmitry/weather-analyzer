<?php

namespace App\Controller;

use App\Entity\Temperature;
use App\Form\TemperatureType;
use App\Repository\TemperatureRepository;
use App\Weather\Exception\WeatherException;
use App\Weather\WeatherProviderCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/temperature")
 */
class TemperatureController extends AbstractController
{
    /**
     * @Route("/", name="temperature_index", methods={"GET"})
     */
    public function index(TemperatureRepository $temperatureRepository): Response
    {
        return $this->render('temperature/index.html.twig', [
            'temperatures' => $temperatureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="temperature_new", methods={"GET","POST"})
     */
    public function new(Request $request, WeatherProviderCollection $weatherProviders): Response
    {
        $temperature = new Temperature();
        $form = $this->createForm(TemperatureType::class, $temperature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            try {
                $avgTemperature = $weatherProviders->getAvgTemperature(
                    $temperature->getCountry(),
                    $temperature->getCity()
                );
            } catch (WeatherException $e) {
                $this->addFlash('error', $e->getMessage());
                return $this->redirectToRoute('temperature_index');
            }

            $temperature->setAvgTemperature($avgTemperature);

            $entityManager->persist($temperature);
            $entityManager->flush();

            return $this->redirectToRoute('temperature_index');
        }

        return $this->render('temperature/new.html.twig', [
            'temperature' => $temperature,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="temperature_show", methods={"GET"})
     */
    public function show(Temperature $temperature): Response
    {
        return $this->render('temperature/show.html.twig', [
            'temperature' => $temperature,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="temperature_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Temperature $temperature, WeatherProviderCollection $weatherProviders): Response
    {
        $form = $this->createForm(TemperatureType::class, $temperature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $avgTemperature = $weatherProviders->getAvgTemperature(
                    $temperature->getCountry(),
                    $temperature->getCity()
                );
            } catch (WeatherException $e) {
                $this->addFlash('error', $e->getMessage());
                return $this->redirectToRoute('temperature_index');
            }

            $temperature->setAvgTemperature($avgTemperature);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('temperature_index');
        }

        return $this->render('temperature/edit.html.twig', [
            'temperature' => $temperature,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="temperature_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Temperature $temperature): Response
    {
        if ($this->isCsrfTokenValid('delete'.$temperature->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($temperature);
            $entityManager->flush();
        }

        return $this->redirectToRoute('temperature_index');
    }
}
