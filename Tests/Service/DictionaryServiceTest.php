<?php

namespace Ady\Bundle\CaptchaBundle\Tests\Service;

use Ady\Bundle\CaptchaBundle\Service\DictionaryService;
use PHPUnit\Framework\TestCase;

class DictionaryServiceTest extends TestCase
{
    public function testCanGetAllDictionary()
    {
        $dictionary = new DictionaryService();

        $words = $dictionary->getWords();

        $this->assertEqualsCanonicalizing(self::DICTIONARY, $words);
    }

    public function testCanGetWordRandomly()
    {
        $dictionary = new DictionaryService();

        $word = $dictionary->getRandomWord();

        $this->assertTrue(in_array(ucfirst(strtolower($word)), self::DICTIONARY));
    }

    private const DICTIONARY = [
        'Accointance',
        'Amphigouri',
        'Anonchalir',
        'Barbiturique',
        'Belluaire',
        'Binaural',
        'Brouillamini',
        'Cacochyme',
        'Caligineux',
        'Cauteleux',
        'Clopinette',
        'Coquecigrue',
        'Cosmogonie',
        'Crapoussin',
        'Damasquiner',
        'Difficultueux',
        'Dipsomanie',
        'Dodeliner',
        'Engoulevent',
        'Ergastule',
        'Escarpolette',
        'Essoriller',
        'Falarique',
        'Flavescent',
        'Forlancer',
        'Galimatias',
        'Gnognotte',
        'Gracile',
        'Halieutique',
        'Harmattan',
        'Hypergamie',
        'Hypnagogique',
        'Illuminisme',
        'Immarcescible',
        'Impavide',
        'Incarnadin',
        'Jactance',
        'Janotisme',
        'Leptosome',
        'Lustrine',
        'Margoulin',
        'Mignardise',
        'Myoclonie',
        'Nonobstant',
        'Nitescence',
        'Obombrer',
        'Objurgation',
        'Odalisque',
        'Palinodie',
        'Panoptique',
        'Parangon',
        'Petrichor',
        'Pusillanime',
        'Ratiociner',
        'Rubigineux',
        'Smaragdin',
        'Soliflore',
        'Sophisme',
        'Stochastique',
        'Thaumaturge',
        'Truchement',
        'Vergogne',
        'Vertugadin',
        'Zinzinuler',
    ];
}
