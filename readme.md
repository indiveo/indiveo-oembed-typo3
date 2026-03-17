# Indiveo oEmbed Typo3

TYPO3-extensie voor het integreren van **Indiveo** als online media provider via **oEmbed** en **FAL**.
Met deze extensie kan TYPO3 Indiveo-media herkennen en weergeven als online media, vergelijkbaar met andere ondersteunde videoplatformen.

## Features
- Ondersteuning voor **Indiveo** als online media bron
- Integratie met **TYPO3 FAL**
- Automatische rendering van Indiveo-media in de frontend
- Compatibel met **TYPO3 v13** en **v14**

## Vereisten

| Component | Versie      |
| --- |-------------|
| PHP | 8.2+        |
| TYPO3 | 13.4 - 14.1 |

## Installatie

### Via Composer
```bash
composer require indiveo/indiveo_oembed_typo3
```

### Extensie activeren

Activeer de extensie daarna in TYPO3 via de **Extension Manager**.

## Gebruik

Na installatie herkent TYPO3 Indiveo-media als online media type.
Je kunt vervolgens een Indiveo-link of mediareferentie toevoegen zoals je dat ook doet met andere online media binnen TYPO3. De extensie zorgt daarna voor de juiste verwerking en weergave.

## Ontwikkeling

### Tests uitvoeren

```bash
vendor/bin/phpunit
```

## Onderhoud
Ontwikkeld en onderhouden door **Indiveo**.