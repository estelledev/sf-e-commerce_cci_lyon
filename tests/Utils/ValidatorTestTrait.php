<?php

namespace App\Tests\Utils;

trait ValidatorTestTrait
{
    public function assertHasErrors(object $entity, int $numberError = 0): void
    {
        self::bootKernel();

        // On valide l'entity (on verifie les contraintes de validation applicatives)
        $errors = self::getContainer()->get('validator')->validate($entity);

        // On initialise un tableau pour stocker les messages d'erreurs
        $messages = [];

        // On boucle sur les violations ($errors)
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . '->' . $error->getMessage();
        }

        $this->assertCount($numberError, $messages, implode(', ', $messages));
    }
}
