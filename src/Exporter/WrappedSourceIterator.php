<?php
declare(strict_types=1);

namespace PBergman\Bundle\DoctrineExportBundle\Exporter;

use Sonata\Exporter\Source\SourceIteratorInterface;

class WrappedSourceIterator implements SourceBuilderInterface
{
    private $name;
    private $description;
    private $iter;

    public function __construct(SourceIteratorInterface $iter, string $name, string $description)
    {
        $this->iter = $iter;
        $this->name = $name;
        $this->description = $description;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getSourceIterator(): SourceIteratorInterface
    {
        return $this->iter;
    }
}
