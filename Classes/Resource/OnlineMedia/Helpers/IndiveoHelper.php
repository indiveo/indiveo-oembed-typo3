<?php

namespace Indiveo\IndiveoOembedTypo3\Resource\OnlineMedia\Helpers;

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\Folder;
use TYPO3\CMS\Core\Resource\OnlineMedia\Helpers\AbstractOEmbedHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class IndiveoHelper extends AbstractOEmbedHelper
{
    protected function getOEmbedUrl($mediaId, $format = 'json')
    {
        return 'https://indiveo.services/oembed?url='.urlencode('https://indiveo.services/embed/'.$mediaId);
    }

    public function transformUrlToFile($url, Folder $targetFolder)
    {
        $videoId = null;

        if (preg_match('#^https?://indiveo\.services/embed/(.*)$#', $url, $matches)) {
            $videoId = $matches[1];
        }

        if (empty($videoId)) {
            return null;
        }

        return $this->transformMediaIdToFile($videoId, $targetFolder, $this->extension);
    }

    public function getPublicUrl(File $file, $relativeToCurrentScript = false)
    {
        return 'https://indiveo.nl';
    }

    public function getPreviewImage(File $file)
    {
        $videoId = $this->getOnlineMediaId($file);
        $temporaryFileName = $this->getTempFolderPath().$file->getExtension().'_'.md5($videoId).'.jpg';

        file_put_contents($temporaryFileName, file_get_contents(__DIR__.'/../../../../Resources/Public/Icons/Extension.png'));
        GeneralUtility::fixPermissions($temporaryFileName);

        return $temporaryFileName;
    }

    public function getMetaData(File $file)
    {
        $metaData = [];

        $oEmbed = $this->getOEmbedData($this->getOnlineMediaId($file));
        if ($oEmbed !== null) {
            $metaData['title'] = $oEmbed['title'];
            $metaData['indiveo_html'] = $oEmbed['html'];
            $metaData['duration'] = $oEmbed['duration'];
        }

        return $metaData;
    }
}
