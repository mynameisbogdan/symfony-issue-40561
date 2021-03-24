<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Form\DataTransformer\EntityToIdentifierTransformer;
use App\Repository\CountryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\ReversedTransformer;

final class CountryCodeChoiceType extends AbstractType
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
        $builder->addModelTransformer(new ReversedTransformer(new EntityToIdentifierTransformer($this->countryRepository, 'code')));
    }

    public function getParent(): string
    {
        return CountryChoiceType::class;
    }
}