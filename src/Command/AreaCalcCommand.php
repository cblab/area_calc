<?php

namespace App\Command;

use App\Service\AreaCalculator;
use App\Service\DataProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;

class AreaCalcCommand extends Command
{
    protected static $defaultName = 'app:area-calc';

    protected function configure()
    {
        $this
            ->setDescription('Performs an area calculation')
            ->setHelp('This command allows you to perform an area calculation...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln([
            'Area Calculation',
            '================',
            '',
        ]);

        $logger = new ConsoleLogger($output);
        $dataProvider = new DataProvider($logger);

        $data = $dataProvider->getData();
        $output->writeln( json_encode($dataProvider->getData()) );

        $areaCalc = new AreaCalculator($data);
        $areaCalc->createBinaryMatrix();
        $areaCalc->printBinaryMatrix();
        $areaCalc->printNumberOfSelectedDots();
        $areaCalc->findRectangleCoordinates();
        $areaCalc->printLargestRectangle();
    }




}