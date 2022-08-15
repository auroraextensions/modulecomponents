<?php
/**
 * HtmlDocumentInterface.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Api
 * @copyright   Copyright (C) 2022 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Api;

use DOMDocument;
use DOMElement;

#[Stringable]
interface HtmlDocumentInterface
{
    public const XML_ROOT_NODE = '<form></form>';
    public const XML_ENCODING = 'UTF-8';
    public const XML_VERSION = '1.0';

    /**
     * @return \DOMDocument
     */
    public function getDocument(): DOMDocument;

    /**
     * @return \DOMElement
     */
    public function getDocumentElement(): DOMElement;

    /**
     * @param \DOMElement $element
     * @return \DOMElement[]
     */
    public function getChildNodes(DOMElement $element): array;

    /**
     * @param \DOMElement $element
     * @param string $tagName
     * @return \DOMElement[]
     */
    public function getChildNodesByTagName(
        DOMElement $element,
        string $tagName
    ): array;

    /**
     * @param \DOMElement $element
     * @return \DOMElement
     */
    public function importNode(DOMElement $element): DOMElement;

    /**
     * @param DOMElement $element
     * @param DOMElement|null $sibling
     * @return DOMElement
     */
    public function insertBefore(
        DOMElement $element,
        ?DOMElement $sibling = null
    ): DOMElement;

    /**
     * @param DOMElement $element
     * @param DOMElement|null $sibling
     * @return DOMElement
     */
    public function insertAfter(
        DOMElement $element,
        ?DOMElement $sibling = null
    ): DOMElement;

    /**
     * @param \DOMElement $element
     * @param \DOMElement|null $parent
     * @return \DOMElement
     */
    public function appendNode(
        DOMElement $element,
        ?DOMElement $parent = null
    ): DOMElement;

    /**
     * @param \DOMElement[] $elements
     * @param \DOMElement|null $parent
     * @return \DOMElement[]
     */
    public function appendNodes(
        array $elements,
        ?DOMElement $parent = null
    ): array;

    /**
     * @return string
     */
    public function __toString(): string;
}
