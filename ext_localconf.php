<?php

use Indiveo\IndiveoOembedTypo3\Resource\OnlineMedia\Helpers\IndiveoHelper;
use Indiveo\IndiveoOembedTypo3\Resource\Rendering\IndiveoRenderer;
use TYPO3\CMS\Core\Resource\Rendering\RendererRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['fal']['onlineMediaHelpers']['indiveo'] = IndiveoHelper::class;
$GLOBALS['TYPO3_CONF_VARS']['SYS']['mediafile_ext'] .= ',indiveo';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['FileInfo']['fileExtensionToMimeType']['indiveo'] = 'video/indiveo';

$rendererRegistry = GeneralUtility::makeInstance(RendererRegistry::class);
$rendererRegistry->registerRendererClass(IndiveoRenderer::class);
unset($rendererRegistry);
