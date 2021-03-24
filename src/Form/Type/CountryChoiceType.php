<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Repository\CountryRepository;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CountryChoiceType extends AbstractType
{
    /** @var CountryRepository */
    private $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['multiple']) {
            $builder->addModelTransformer(new CollectionToArrayTransformer());
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'choices' => function (Options $options): iterable {
                    return $this->countryRepository->findAll();
                },
                'choice_value' => 'code',
                'choice_label' => 'name',
                'choice_translation_domain' => false,
            ])
        ;
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}