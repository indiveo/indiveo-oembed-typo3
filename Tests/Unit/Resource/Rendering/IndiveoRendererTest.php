<?php

namespace Indiveo\IndiveoOembedTypo3\Tests\Unit\Resource\Rendering;

use Indiveo\IndiveoOembedTypo3\Resource\OnlineMedia\Helpers\IndiveoHelper;
use Indiveo\IndiveoOembedTypo3\Resource\Rendering\IndiveoRenderer;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class IndiveoRendererTest extends UnitTestCase
{
    private IndiveoRenderer $indiveo;

    protected bool $resetSingletonInstances = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->indiveo = new IndiveoRenderer;
    }

    #[Test]
    public function can_get_priority(): void
    {
        $this->assertSame(1, $this->indiveo->getPriority());
    }

    #[Test]
    public function can_render_with_matching_mime_type_returns_true(): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['fal']['onlineMediaHelpers']['indiveo'] = IndiveoRenderer::class;

        $file = $this->createMock(File::class);
        $file->expects($this->once())->method('getMimeType')->willReturn('video/indiveo');
        $file->expects($this->exactly(3))->method('getExtension')->willReturn('indiveo');

        $this->assertTrue($this->indiveo->canRender($file));
    }

    #[Test]
    public function can_render_with_matching_mime_type_returns_false(): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['fal']['onlineMediaHelpers']['indiveo'] = IndiveoRenderer::class;

        $file = $this->createMock(File::class);
        $file->expects($this->once())->method('getMimeType')->willReturn('video/youtube');
        $file->expects($this->once())->method('getExtension')->willReturn('youtube');

        $this->assertFalse($this->indiveo->canRender($file));
    }

    #[Test]
    public function render_returns_indiveo_html(): void
    {
        $iframe = 'mock_oembed_result';

        $helper = $this->createMock(IndiveoHelper::class);
        $helper->expects($this->once())->method('getMetaData')->with($this->isInstanceOf(File::class))->willReturn(['indiveo_html' => $iframe]);

        $this->indiveo->onlineMediaHelper = $helper;

        $result = $this->indiveo->render($this->createStub(File::class), 100, 100);

        $this->assertSame($iframe, $result);
    }
}
