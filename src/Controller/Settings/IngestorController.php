<?php

namespace App\Controller\Settings;

use App\Entity\Ingestor;
use App\Form\IngestorType;
use App\Repository\IngestorRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route( '/settings/ingestor' )]
#[IsGranted( 'ROLE_ADMIN' )]
class IngestorController extends AbstractController {
	#[Route( '/', name: 'app_ingestor_index', methods: [ 'GET' ] )]
	public function index( IngestorRepository $ingestorRepository ): Response {
		return $this->render( 'ingestor/index.html.twig', [
			'ingestors' => $ingestorRepository->findAll(),
		] );
	}

	#[Route( '/new', name: 'app_ingestor_new', methods: [ 'GET', 'POST' ] )]
	public function new( Request $request, IngestorRepository $ingestorRepository ): Response {
		$ingestor = new Ingestor();
		$form     = $this->createForm( IngestorType::class, $ingestor );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$ingestorRepository->save( $ingestor, true );

			return $this->redirectToRoute( 'app_ingestor_index', [], Response::HTTP_SEE_OTHER );
		}

		return $this->renderForm( 'ingestor/new.html.twig', [
			'ingestor' => $ingestor,
			'form'     => $form,
		] );
	}

	#[Route( '/{id}', name: 'app_ingestor_show', methods: [ 'GET' ] )]
	public function show( Ingestor $ingestor ): Response {
		return $this->render( 'ingestor/show.html.twig', [
			'ingestor' => $ingestor,
		] );
	}

	#[Route( '/{id}/edit', name: 'app_ingestor_edit', methods: [ 'GET', 'POST' ] )]
	public function edit( Request $request, Ingestor $ingestor, IngestorRepository $ingestorRepository ): Response {
		$form = $this->createForm( IngestorType::class, $ingestor );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$ingestorRepository->save( $ingestor, true );

			return $this->redirectToRoute( 'app_ingestor_index', [], Response::HTTP_SEE_OTHER );
		}

		return $this->renderForm( 'ingestor/edit.html.twig', [
			'ingestor' => $ingestor,
			'form'     => $form,
		] );
	}

	#[Route( '/{id}', name: 'app_ingestor_delete', methods: [ 'POST' ] )]
	public function delete( Request $request, Ingestor $ingestor, IngestorRepository $ingestorRepository ): Response {
		if ( $this->isCsrfTokenValid( 'delete' . $ingestor->getId(), $request->request->get( '_token' ) ) ) {
			$ingestorRepository->remove( $ingestor, true );
		}

		return $this->redirectToRoute( 'app_ingestor_index', [], Response::HTTP_SEE_OTHER );
	}
}
