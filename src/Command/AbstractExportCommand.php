<?php
declare(strict_types=1);

namespace PBergman\Bundle\DoctrineExportBundle\Command;

use Sonata\Exporter\Writer\CsvWriter;
use Sonata\Exporter\Writer\JsonWriter;
use Sonata\Exporter\Writer\WriterInterface;
use Sonata\Exporter\Writer\XlsWriter;
use Sonata\Exporter\Writer\XmlExcelWriter;
use Sonata\Exporter\Writer\XmlWriter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractExportCommand extends Command
{
    private $writer;

    protected function configure()
    {
        $this
            ->addOption('file', 'f', InputOption::VALUE_REQUIRED, 'The file to write to.', '/dev/stdout')
            ->addOption('format', 'F', InputOption::VALUE_REQUIRED, 'The output format', 'xls');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);

        switch ($input->getOption('format')) {
            case 'xls':
                $this->writer = new XlsWriter($input->getOption('file'));
                break;
            case 'csv':
                $this->writer = new CsvWriter($input->getOption('file'));
                break;
            case 'json':
                $this->writer = new JsonWriter($input->getOption('file'));
                break;
            case 'xml':
                $this->writer = new XmlWriter($input->getOption('file'));
                break;
            case 'excel':
                $this->writer = new XmlExcelWriter($input->getOption('file'));
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Invalid export format "%s", should be one of "xls", "csv", "json", "xml", "excel"', $input->getOption('format')));
        }
    }

    protected function getWriter(): ?WriterInterface
    {
        return $this->writer;
    }
}
