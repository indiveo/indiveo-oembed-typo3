<?php

namespace Indiveo\IndiveoOembedTypo3\Resource\Rendering;

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Resource\OnlineMedia\Helpers\OnlineMediaHelperInterface;
use TYPO3\CMS\Core\Resource\OnlineMedia\Helpers\OnlineMediaHelperRegistry;
use TYPO3\CMS\Core\Resource\Rendering\FileRendererInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class IndiveoRenderer implements FileRendererInterface
{
    /**
     * @var OnlineMediaHelperInterface|false
     */
    public $onlineMediaHelper;

    /**
     * @return int
     */
    public function getPriority()
    {
        return 1;
    }

    /**
     * @param  FileInterface  $file  File of FileReference to render
     * @return bool
     */
    public function canRender(FileInterface $file)
    {
        return ($file->getMimeType() === 'video/indiveo' || $file->getExtension() === 'indiveo') && $this->getOnlineMediaHelper($file) !== false;
    }

    /**
     * @return false|OnlineMediaHelperInterface
     */
    public function getOnlineMediaHelper(FileInterface $file)
    {
        if ($this->onlineMediaHelper === null) {
            $orgFile = $file;

            if ($orgFile instanceof FileReference) {
                $orgFile = $orgFile->getOriginalFile();
            }

            if ($orgFile instanceof File) {
                $this->onlineMediaHelper = GeneralUtility::makeInstance(OnlineMediaHelperRegistry::class)->getOnlineMediaHelper($orgFile);
            } else {
                $this->onlineMediaHelper = false;
            }
        }

        return $this->onlineMediaHelper;
    }

    /**
     * @param  int|string  $width  TYPO3 known format; examples: 220, 200m or 200c
     * @param  int|string  $height  TYPO3 known format; examples: 220, 200m or 200c
     * @return string
     */
    public function render(FileInterface $file, $width, $height, array $options = [])
    {
        if ($file instanceof FileReference) {
            $orgFile = $file->getOriginalFile();
        } else {
            $orgFile = $file;
        }

        return $this->getOnlineMediaHelper($file)->getMetaData($orgFile)['indiveo_html'] ?? '';
    }
}
