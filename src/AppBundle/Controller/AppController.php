<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Publication;
use AppBundle\Entity\Science;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AppController
 * @package AppBundle\Controller
 */
class AppController extends Controller
{
    /**
     * Home page action.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
	{
        $latestPublications = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Publication')
            ->findBy([], ['publishedAt' => 'DESC'], 3);

        return $this->render('AppBundle:App:home.html.twig', [
            'publications' => $latestPublications,
        ]);
    }

public function scienceListAction()
	{
		$sciences = $this
			->getDoctrine()
			->getRepository('AppBundle:Science')
			->findBy([], ['title' => 'ASC']);

		return $this->render('AppBundle:App:sciences.html.twig', [
			'sciences' => $sciences
			]);
	}

public function scienceDetailAction($scienceId)
	{
		$science = $this
			->getDoctrine()
			->getRepository('AppBundle:Science')
			->findOneBy(['id' => $scienceId]);

		$plublicationsTheme = $this
			->getDoctrine()
			->getRepository('AppBundle:Publication')
			->findby(['science' => $scienceId], ['title' => 'ASC']);

		return $this->render('AppBundle:App:science.html.twig', [
			'science' => $science,
			'publications' => $plublicationsTheme
		]);
	}

public function publicationDetailAction($scienceId, $publicationId)
	{
		$publication = $this
			->getDoctrine()
			->getRepository('AppBundle:Publication')
			->findOneBy(['id' => $publicationId]);

		$science = $this
			->getDoctrine()
			->getRepository('AppBundle:Science')
			->findOneBy(['id' => $scienceId]);

		return $this->render('AppBundle:App:publication.html.twig', [
			'publication' => $publication,
			'science' => $science
		]);
	}

public function publicationNewAction()
	{
		$publication = new Publication();
		$form = $this
			->createForm('AppBundle\Form\PublicationType', $publication, [
                    'admin_mode' => false,
                ]);

		return $this->render('AppBundle:App:publier.html.twig', array(
            'publication' => $publication,
            'form' => $form->createView(),
        ));
	}
}