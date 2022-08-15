<?php
/**
 * HtmlDocument.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Model\Html\Document
 * @copyright   Copyright (C) 2022 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Model\Html\Document;

use DOMDocument;
use DOMDocumentFactory;
use DOMElement;
use AuroraExtensions\ModuleComponents\Api\HtmlDocumentInterface;
use AuroraExtensions\ModuleComponents\Component\Html\Document\HtmlDocumentTrait;

class HtmlDocument implements HtmlDocumentInterface
{
    use HtmlDocumentTrait;

    /**
     * @param DOMDocumentFactory $documentFactory
     * @param string $version
     * @param string $encoding
     * @param string $html
     * @return void
     */
    public function __construct(
        DOMDocumentFactory $documentFactory,
        string $version = self::XML_VERSION,
        string $encoding = self::XML_ENCODING,
        string $html = self::XML_ROOT_NODE
    ) {
        $this->document = $documentFactory->create([
            'version' => $version,
            'encoding' => $encoding,
        ]);
        $this->document->loadHTML($html);
    }
}
