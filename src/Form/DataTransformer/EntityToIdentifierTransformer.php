<?php

declare(strict_types=1);

namespace App\Form\DataTransformer;

use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\PropertyAccess\PropertyAccess;

final class EntityToIdentifierTransformer implements DataTransformerInterface
{
    /** @var ObjectRepository */
    private $repository;

    /** @var string */
    private $identifier;

    public function __construct(ObjectRepository $repository, string $identifier)
    {
        $this->repository = $repository;
        $this->identifier = $identifier;
    }

    public function transform($value)
    {
        if ($value === null) {
            return null;
        }

        return PropertyAccess::createPropertyAccessor()->getValue($value, $this->identifier);
    }

    public function reverseTransform($value)
    {
        if ($value === null) {
            return null;
        }

        $entity = $this->repository->findOneBy([$this->identifier => $value]);
        if ($entity === null) {
            throw new TransformationFailedException(
                sprintf('Could not find "%s" with "%s" = "%s"', $this->repository->getClassName(), $this->identifier, $value)
            );
        }

        return $entity;
    }
}