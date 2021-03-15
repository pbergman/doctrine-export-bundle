<?php
declare(strict_types=1);

namespace PBergman\Bundle\DoctrineExportBundle\Exporter;

class SourceBuilderManager implements \IteratorAggregate
{
    private $builders;

    public function add(SourceBuilderInterface $builder): SourceBuilderManager
    {
        $this->builders[$builder->getName()] = $builder;
        return $this;
    }

    public function get(string $name): ?SourceBuilderInterface
    {
        return $this->builders[$name] ?? null;
    }

    public function has(string $name): bool
    {
        return isset($this->builders[$name]);
    }

    public function remove(string $name): SourceBuilderManager
    {
        unset($this->builders[$name]);
        return $this;
    }

    /** @return SourceBuilderInterface[] */
    public function getIterator(): \Generator
    {
        foreach ($this->builders as $name => $builder) {
            yield $name => $builder;
        }
    }
}