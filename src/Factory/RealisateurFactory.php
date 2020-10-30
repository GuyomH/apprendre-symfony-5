<?php

namespace App\Factory;

use App\Entity\Realisateur;
use App\Repository\RealisateurRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Realisateur|Proxy findOrCreate(array $attributes)
 * @method static Realisateur|Proxy random()
 * @method static Realisateur[]|Proxy[] randomSet(int $number)
 * @method static Realisateur[]|Proxy[] randomRange(int $min, int $max)
 * @method static RealisateurRepository|RepositoryProxy repository()
 * @method Realisateur|Proxy create($attributes = [])
 * @method Realisateur[]|Proxy[] createMany(int $number, $attributes = [])
 */
final class RealisateurFactory extends ModelFactory
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
            // ->afterInstantiate(function(Realisateur $realisateur) {})
        ;
    }

    protected static function getClass(): string
    {
        return Realisateur::class;
    }
}
