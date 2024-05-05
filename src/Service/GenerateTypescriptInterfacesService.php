<?php 

namespace App\Service;

use RecursiveDirectoryIterator;
use ReflectionClass;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

class GenerateTypescriptInterfacesService {
    private function scanEntities() {
        $fs = new Filesystem();
        $finder = new Finder();

        $finder->files('*.php')->in(dirname(__FILE__).'/../Entity');

        $entityFiles = [];

        foreach ($finder as $file) {
            $entityClass = 'App\Entity\\'. str_replace('/','\\',str_replace('.php','',$file->getRelativePathname()));

            $refl = new ReflectionClass($entityClass);

            if ($refl->isTrait()) {
                continue;
            }

            $entityFiles[] = $entityClass;
        }

        return $entityFiles;
    }

    private function getClassProperties(object $entity): array {

        $reflectionClass = new ReflectionClass($entity::class);
        $includedProperties = [];
        $properties = [];

        while ($reflectionClass) {
            // Get properties and merge them, ensuring no duplicates
            $properties = array_merge($reflectionClass->getProperties(), $properties);

            // Move up to the parent class
            $reflectionClass = $reflectionClass->getParentClass();
        }
        return $properties;
    }

    private function prepareTypescriptInterface(object $entity): string {
        $reflectionClass = new ReflectionClass($entity);
        
        $interfaceName = $reflectionClass->getShortName();
        $properties = $this->getClassProperties($entity);

        $tsProperties = [];

        foreach ($properties as $property) {
            $name = $property->getName();
            $type = $this->mapToTypescriptType($property->getType()->getName());

            $tsProperties[] = "    $name: $type;";
        }

        $interfaceString = "export interface $interfaceName {\n". implode("\n", $tsProperties)."\n}";

        return $interfaceString;
    }


    private function mapToTypescriptType(?string $type): string {
        $typeMapping = [
            'int' => 'number',
            'float' => 'number',
            'string' => 'string',
            'bool' => 'boolean',
            'array' => 'any[]',
            'object' => 'object'
        ];

        return $typeMapping[$type] ?? 'any';
    }

    public function generateTypeScriptInterfaces(): array {
        $entities = $this->scanEntities();

        $typeScriptInterfaces = [];

        foreach ($entities as $entity) {
            $typeScriptInterfaces[$entity] = $this->prepareTypescriptInterface(new $entity());
        }

        return $typeScriptInterfaces;
    }
}