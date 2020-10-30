<?php

namespace App\Factory;

use App\Entity\Hashtag;
use App\Repository\HashtagRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Hashtag|Proxy findOrCreate(array $attributes)
 * @method static Hashtag|Proxy random()
 * @method static Hashtag[]|Proxy[] randomSet(int $number)
 * @method static Hashtag[]|Proxy[] randomRange(int $min, int $max)
 * @method static HashtagRepository|RepositoryProxy repository()
 * @method Hashtag|Proxy create($attributes = [])
 * @method Hashtag[]|Proxy[] createMany(int $number, $attributes = [])
 */
final class HashtagFactory extends ModelFactory
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
            // On utilise le faker pour générer un mot au hasard que l'on préfixe avec le symbole "#"
            'terme' => '#' . self::faker()->word,
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Hashtag $hashtag) {})
        ;
    }

    protected static function getClass(): string
    {
        return Hashtag::class;
    }
}
