<?php

namespace Ady\Bundle\CaptchaBundle\Service;

class DictionaryService
{
    protected const DICTIONARY = [
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

    public function getWords(): array
    {
        return self::DICTIONARY;
    }

    public function getRandomWord(): string
    {
        $dictionary = $this->getWords();

        return strtoupper($dictionary[array_rand($dictionary)]);
    }
}
