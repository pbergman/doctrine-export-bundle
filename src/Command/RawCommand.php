<?php
declare(strict_types=1);

namespace PBergman\Bundle\DoctrineExportBundle\Command;

use Doctrine\Persistence\ConnectionRegistry;
use Sonata\Exporter\Handler;
use Sonata\Exporter\Source\DoctrineDBALConnectionSourceIterator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RawCommand extends AbstractExportCommand
{
    protected static $defaultName = 'pbergman:export:raw';

    private $registry;

    public function __construct(ConnectionRegistry $registry)
    {
        parent::__construct();

        $this->registry = $registry;
    }

    protected function configure()
    {
        parent::configure();

        $this
            ->setDescription('Export given query.')
            ->addOption('connection', 'c', InputOption::VALUE_REQUIRED, 'The connection name to use for running query.', 'default')
            ->addArgument('query', InputArgument::REQUIRED, 'The query to export.');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (null === $conn = $this->registry->getConnection($input->getOption('connection'))) {
            throw new \InvalidArgumentException('No connection exists with name "' . $input->getOption('connection') . '"');
        }

        if ('-' === $query = $input->getArgument('query')) {
            $query = stream_get_contents(STDIN);
        }

        (new Handler(new DoctrineDBALConnectionSourceIterator($conn, $query), $this->getWriter()))->export();

        return 0;
    }
}
