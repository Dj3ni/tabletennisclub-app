GameService::startGame()
│
├── Crée les GameParticipants (avec handicap calculé)
│
└── SetService::startSet(game, setNumber)
    │
    ├── Crée le Set (status: in_progress)
    │
    └── GameService::recordSetScore(set, scores)
        │
        ├── Met à jour les scores du Set
        ├── Détermine le gagnant du Set
        │
        └── GameService::checkGameOver(game)
            │
            ├── NON → SetService::startSet() suivant
            └── OUI → GameService::finalizeGame()
