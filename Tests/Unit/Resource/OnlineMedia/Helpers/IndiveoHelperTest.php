<?php

namespace Indiveo\IndiveoOembedTypo3\Tests\Unit\Resource\OnlineMedia\Helpers;

use Indiveo\IndiveoOembedTypo3\Resource\OnlineMedia\Helpers\IndiveoHelper;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\Folder;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class IndiveoHelperTest extends UnitTestCase
{
    #[Test]
    public function get_oembed_url_returns_url()
    {
        $class = (new class('indiveo') extends IndiveoHelper
        {
            public function getOEmbedUrl($mediaId, $format = 'json')
            {
                return parent::getOEmbedUrl($mediaId, $format);
            }
        });

        $this->assertEquals(
            'https://indiveo.services/oembed?url=https%3A%2F%2Findiveo.services%2Fembed%2Ff1557bd7-1584-495a-aecd-827189d6a471',
            $class->getOEmbedUrl('f1557bd7-1584-495a-aecd-827189d6a471')
        );
    }

    #[Test]
    public function get_transform_url_to_file()
    {
        $helper = $this->getMockBuilder(IndiveoHelper::class)->onlyMethods(['transformMediaIdToFile'])->disableOriginalConstructor()->getMock();
        $helper->expects($this->once())
            ->method('transformMediaIdToFile')
            ->with('f1557bd7-1584-495a-aecd-827189d6a471', $this->isInstanceOf(Folder::class))
            ->willReturnCallback(function () {
                return $this->createStub(File::class);
            });

        $this->assertInstanceOf(
            File::class,
            $helper->transformUrlToFile(
                'https://indiveo.services/embed/f1557bd7-1584-495a-aecd-827189d6a471',
                $this->createStub(Folder::class)
            )
        );
    }

    #[Test]
    public function public_url()
    {
        $this->assertSame('https://indiveo.nl', (new IndiveoHelper('indiveo'))->getPublicUrl($this->createStub(File::class)));
    }

    #[Test]
    public function preview_image()
    {
        $helper = $this->getMockBuilder(IndiveoHelper::class)->onlyMethods(['getPreviewImage'])->disableOriginalConstructor()->getMock();
        $helper->expects($this->once())->method('getPreviewImage')->with($this->isInstanceOf(File::class))
            ->willReturn('/var/www/html/typo3temp/assets/online_media/indiveo_05f9456a2de0166906aae0c98492472f.jpg');

        $this->assertSame('/var/www/html/typo3temp/assets/online_media/indiveo_05f9456a2de0166906aae0c98492472f.jpg', $helper->getPreviewImage($this->createStub(File::class)));
    }

    #[Test]
    public function get_meta_data()
    {
        $helper = $this->getMockBuilder(IndiveoHelper::class)->onlyMethods(['getOnlineMediaId', 'getOEmbedData'])->disableOriginalConstructor()->getMock();
        $helper->expects($this->once())->method('getOnlineMediaId')->with($this->isInstanceOf(File::class))->willReturn('f1557bd7-1584-495a-aecd-827189d6a471');
        $helper->expects($this->once())->method('getOEmbedData')->with('f1557bd7-1584-495a-aecd-827189d6a471')->willReturn([
            'version' => '1.0',
            'type' => 'rich',
            'title' => 'mock',
            'html' => 'mock_oembed_result',
            'width' => 800,
            'height' => 450,
            'duration' => 123,
        ]);

        $this->assertSame([
            'title' => 'mock',
            'indiveo_html' => 'mock_oembed_result',
            'duration' => 123,
        ], $helper->getMetaData(
            $this->createStub(File::class)
        ));
    }
}
