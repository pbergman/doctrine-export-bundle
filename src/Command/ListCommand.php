<?php
declare(strict_types=1);

namespace PBergman\Bundle\DoctrineExportBundle\Command;

use PBergman\Bundle\DoctrineExportBundle\Exporter\SourceBuilderManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends Command
{
    protected static $defaultName = 'pbergman:export:list';

    private $manager;

    protected function configure()
    {
        $this->setDescription('Print all pre defined exports.');
    }

    public function __construct(SourceBuilderManager $manager)
    {
        parent::__construct();
        $this->manager = $manager;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = new Table($output);
        $table->setHeaders(['name', 'description']);
        $table->setStyle('symfony-style-guide');

        foreach ($this->manager as $builder) {
            $table->addRow([$builder->getName(), $builder->getDescription()]);
        }

        $table->render();

        return 0;
    }
}