<?php 

namespace App\Command;

use App\Service\GenerateTypescriptInterfacesService;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:generate:typescript-interfaces')]
class GenerateTypescriptInterfacesCommand extends Command {
    

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $outputDir =  'assets/src/Interfaces';

        $fs = new Filesystem();

        if(!$fs->exists($outputDir)){
            $fs->mkdir($outputDir);
        }       

        $service = new GenerateTypescriptInterfacesService();
        $generatedInterfaces = $service->generateTypeScriptInterfaces();

        foreach ($generatedInterfaces as $interfaceName => $interfaceContent) {
            $name = explode('\\', $interfaceName);
            $name = $name[count($name) - 1];

            $filePath = rtrim($outputDir, '/') . '/' . $name . '.ts';

            if (!$fs->exists($filePath)) {
                file_put_contents($filePath, $interfaceContent);
            }
        }

        $io->success('Successfully generated TypeScript interfaces');

        return 0;
    }
}