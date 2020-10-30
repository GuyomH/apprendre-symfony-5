<?php

namespace App\Factory;

use App\Entity\Film;
use App\Repository\FilmRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Film|Proxy findOrCreate(array $attributes)
 * @method static Film|Proxy random()
 * @method static Film[]|Proxy[] randomSet(int $number)
 * @method static Film[]|Proxy[] randomRange(int $min, int $max)
 * @method static FilmRepository|RepositoryProxy repository()
 * @method Film|Proxy create($attributes = [])
 * @method Film[]|Proxy[] createMany(int $number, $attributes = [])
 */
final class FilmFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    private static $index = 0; // Permet de conserver la dernière valeur de la propriété à chaque appel de l'objet

    protected function getDefaults(): array
    {
        $films = [ // nb = 304
            "Casino Royale","Quantum of Solace","Skyfall","8 mile","L'armée des 12 singes","2009 Lost Memories","21 Grams","25th Hour","28 jours plus tards","28 semaines plus tard","300","36 quai des orfèvres","L'age de glace","Alexandre","Ali","Alice aux pays des merveilles","Alien","Alien 2","Alien 3","Alien 4","American Gangster","American History X","American Psycho ","Any Given Sunday","Apocalypse Now","Armageddon","L'arme Fatale ","L'arme Fatale 2","L'arme Fatale 3","L'arme Fatale 4","Les associés","L'associé du du diable ","Metro 123","Avatar","Bad Boys","Bad Boys 2","Basic Instict","Batman ","Batman Begins","Before the devil know your dead","La belle et la bête","Le flic de beverly hills","Le flic de beverly hills 2","Le flic de beverly hills 3","Big Fish","Black Hawk Down","Blade","Blade 2","Bloodsport / Timecop","Bloodwork","La mémoire dans la peau","La mort dans la peau","La vengeance dans la peau","Boys in the wood","Braveheart","Carlito's Way","Casino","Arrête moi si tu peu","Cinderella Man","La cité de dieu","City Hall","Cloverfield","Collateral","Collision","Les noces funebres","Crazy Stupid Love","Crimson tide","Daredevil","Dark blue","Dark knight","Dark knight rises","Le jour d'après","Daylight","De caunes & garcia 1","De caunes & garcia 2","Deep impact","Departed","Derapage incotrolé","Destination final","Destination final 2","Die Hard","Die Hard 2","Die Hard 3","Die Hard 4","Discours d'un roi","Dog day afternoon","Dogville","Donnie Brasco","Dragon","Dragon Rouge","Drive","La duchesse","Edouard aux mains d'argent","Empire","Ennemie d'état ","Esprits rebelles","Les experts par Tarrantino","Eyes wide shut","The fall","Falling Dawn","Nikita","5e element","Fight Club","Fighter","Final Fantasy","Nemo","Finding Neverland","Rambo","Forrest gump","Fantome contre fantome","Full metal jacket","Gangs of NY","Get smart","Gladiator","Le Parrain","Le Parrain 2","Le parrain 3","Goodfellas","60 sec chrono","La ligne verte","La guerre des mondes","Les guignols 15 ans","Hannibal","Haute Voltige","He got game","Heat","Hellboy","Hellboy 2","History of violence","Hitch","The holliday","Hulk ","A la poursuite d'octobre rouge","Je suis une légende ","Inception","Identity","Independance Day","Indiana Jones 1","Indiana Jones 2","Indiana Jones 3","Inglorious Bastard","Inside Man","Entretien avec un vampire","Intouchable ","Il était une fois en amérique","I Robot","Iron man","John Q","Jurassik Park","Jurassik Park 2","Jurassik Park 3","Kill Bill 1","Kill Bill 2","The Kingdom","Kingdom of heaven","King Kong","Chevalier","K Pax","Ladder 49","Les larmes du soleil","Dernier samourai","Layer Cake","Leon","La ligne rouge","Lord of war","Madagascar","Malcom X","Le masque de zorro","Master and commander","Match point","Memento","Miami Vice","MIB","Midnight Express","Minority repport","Mission Impossible","Mission Impossible 2","Mission Impossible 3","Mission Impossible 4","Mister and Mme Smith","Mystic River","Narc","New police story","L'etrange noel de M Jack","Salvadore","Platoon","Wall Steet","Talk radio","Ne un 4 juillet","The doors","JFK","Heaven and hearth","Natural born killer","Nixon","U Turn","Any Given Sunday","Oliver Stone america","Orange mecanique","Original Sin","The other","Out for justice","Out of time","We own the night","Panic room","Panic a needle park","The patriot","Payback","Pearl Harbor","The perfect storm","Les petits mouchoirs","Philadelphia","The pianist","Piege en haute mer","Pirate des caraibe","Pitch black","Le plus beau des combats","Le prestige","Public ennemi","Pulp fiction","Rain Man","La rancon","La recrue","Reign of fire","Reign over me","Resident evil","Resident evil 2","Resident evil 3","Retour vers le futur","Retour vers le futur 2","Retour vers le futur 3","Rocky","Rocky 2","Rocky 3","Rocky 4","Rocky 5","Road to graceland","Mad Max 2","Robin hood","Rock","Rocky Balboa","Roger rabbit","Le roi lion","SAV des emissions saison 1, 2, 3","Il faut sauver le soldat ryan","Seven","7 ans au tibet","Scarface","Boxcare Bertha","New York New York","The last waltz","Ragging bull","Who that talking at my door","Mean Street","Alice doesn't live here anymore","After hours","Les affranchis","Shaft","Sherlock Holmes","Shinning","Shreck ","Shreck 2","Sign","Le silence des agneaux","Sin city","6e sens","Snake Eyes","Spartan","Do the right thing","Jungle Fever","Clokers","Starship Troopers","Star Wars","Star Wars 2","Star Wars 3","Swat","Sweeney todd","Talking lives","Titanic","Le terminal","Terminator","Terminator 2","Terminator 3","Traffic","Training day","Trainspotting","Le tres tres bien de jamel","The truman show","Incassable","Underworld","Universal soldier","Un jour","Les incorrubtibles","V pour vendetta","Vicky Christina Barcellona","Le village","Volte Face","Waterworld","Watchmen","Wild wild west","Wild Things","X men","X men 2","X men 3","Xxx",
        ];

        return [
            // TODO add your default values here (https://github.com/zenstruck/foundry#model-factories)
            // On utilise la liste de films pour peupler la base (https://www.fichier-xls.fr/2013/07/14/liste-films/)
            'titre' => $films[self::$index++],
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Film $film) {})
        ;
    }

    protected static function getClass(): string
    {
        return Film::class;
    }
}
