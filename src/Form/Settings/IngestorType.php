<?php

namespace App\Form\Settings;

use App\Entity\Ingestor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IngestorType extends AbstractType {
	public function buildForm( FormBuilderInterface $builder, array $options ): void {
		$builder
			->add( 'name' )
			->add( 'type' )
			->add( 'pull_ip' )
			->add( 'pull_port' )
			->add( 'push_port' )
			->add( 'source_type' )
			->add( 'active' )
			->add( 'pending_command' );
	}

	public function configureOptions( OptionsResolver $resolver ): void {
		$resolver->setDefaults( [
			'data_class' => Ingestor::class,
		] );
	}
}
