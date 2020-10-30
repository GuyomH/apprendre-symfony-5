<?php

namespace App\Factory;

use App\Entity\Acteur;
use App\Repository\ActeurRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Acteur|Proxy findOrCreate(array $attributes)
 * @method static Acteur|Proxy random()
 * @method static Acteur[]|Proxy[] randomSet(int $number)
 * @method static Acteur[]|Proxy[] randomRange(int $min, int $max)
 * @method static ActeurRepository|RepositoryProxy repository()
 * @method Acteur|Proxy create($attributes = [])
 * @method Acteur[]|Proxy[] createMany(int $number, $attributes = [])
 */
final class ActeurFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://github.com/zenstruck/foundry#model-factories)
            // On utilise le faker pour générer le nom sous la forme : Prénom Nom
            'nom' => self::faker()->unique()->lastName . ' ' . self::faker()->unique()->firstName,
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Acteur $acteur) {})
        ;
    }

    protected static function getClass(): string
    {
        return Acteur::class;
    }
}
