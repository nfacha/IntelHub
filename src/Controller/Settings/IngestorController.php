<?php

namespace App\Controller\Settings;

use App\Entity\Ingestor;
use App\Form\Settings\IngestorType;
use App\Repository\IngestorRepository;
use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route( '/settings/ingestor' )]
#[IsGranted( 'ROLE_ADMIN' )]
class IngestorController extends AbstractController {
	#[Route( '/', name: 'app_ingestor_index', methods: [ 'GET' ] )]
	public function index( IngestorRepository $ingestorRepository, DataTableFactory $dtf, Request $request ): Response {

		$table = $dtf->create()
			->add( 'id', TextColumn::class, [ 'label' => 'ID', 'className' => 'text-center' ] )
			->add( 'name', TextColumn::class, [ 'label' => 'Name', 'className' => 'text-center' ] )
			->add( 'type', TextColumn::class, [ 'label' => 'Type', 'className' => 'text-center' ] )
			->add( 'pull_ip', TextColumn::class, [ 'label' => 'Pull IP', 'className' => 'text-center' ] )
			->add( 'pull_port', TextColumn::class, [ 'label' => 'Pull Port', 'className' => 'text-center' ] )
			->add( 'push_port', TextColumn::class, [ 'label' => 'Push Port', 'className' => 'text-center' ] )
			->add( 'source_type', TextColumn::class, [ 'label' => 'Source Type', 'className' => 'text-center' ] )
			->createAdapter( ArrayAdapter::class, [] )
			->handleRequest( $request );

		if($table->isCallback()){
			return $table->getResponse();
		}

		return $this->render( 'ingestor/index.html.twig', [
			'datatable' => $table,
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
