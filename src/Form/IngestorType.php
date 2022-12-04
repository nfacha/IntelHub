<?php

namespace App\Form;

use App\Entity\Ingestor;
use App\Enum\BooleanType;
use App\Enum\SourceFeedType;
use App\Enum\SourceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IngestorType extends AbstractType {
	public function buildForm( FormBuilderInterface $builder, array $options ): void {
		$builder
			->add( 'name', null, [
				'label' => false,
				'attr'  => [
					'placeholder' => 'Name',
				],
			] )
			->add( 'type', ChoiceType::class, [
				'label'   => false,
				'choices' => SourceFeedType::getChoices(),
			] )
			->add( 'pull_ip' )
			->add( 'pull_port' )
			->add( 'push_port' )
			->add( 'source_type', ChoiceType::class, [
				'label'   => false,
				'choices' => SourceType::getChoices(),
			] )
			->add( 'active', ChoiceType::class, [
				'label'   => false,
				'choices' => BooleanType::getChoicesActiveInactive(),
			] )
			->add( 'pending_command', null, [
				'label'    => false,
				'disabled' => true,
				'attr'     => [
					'readonly' => true,
				],
			] );
	}

	public function configureOptions( OptionsResolver $resolver ): void {
		$resolver->setDefaults( [
			'data_class' => Ingestor::class,
		] );
	}
}
