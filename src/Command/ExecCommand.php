<?php
declare(strict_types=1);

namespace PBergman\Bundle\DoctrineExportBundle\Command;

use PBergman\Bundle\DoctrineExportBundle\Exporter\SourceBuilderManager;
use Sonata\Exporter\Handler;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExecCommand extends AbstractExportCommand
{
    protected static $defaultName = 'pbergman:export:exec';

    private $manager;

    protected function configure()
    {
        parent::configure();

        $this
            ->setDescription('Export pre defined query.')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of pre defined query.');
    }

    public function __construct(SourceBuilderManager $manager)
    {
        parent::__construct();
        $this->manager = $manager;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (null === $builder = $this->manager->get($input->getArgument('name'))) {
            throw new \InvalidArgumentException('No pre defined query exists with name "' .  $input->getArgument('name') . '"');
        }

        (new Handler($builder->getSourceIterator(), $this->getWriter()))->export();

        return 0;
    }
}
