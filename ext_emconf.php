<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Indiveo oEmbed Typo3',
    'description' => 'TYPO3-extensie voor het integreren van Indiveo als online media provider via oEmbed en FAL.',
    'category' => 'plugin',
    'state' => 'stable',
    'author' => 'indiveo',
    'author_email' => 'ict@indiveo.nl',
    'author_company' => 'indiveo',
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-14.9.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
