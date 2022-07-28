<?php
/**
 * HtmlDocumentTrait.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Component\Html\Document
 * @copyright   Copyright (C) 2022 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Component\Html\Document;

use DOMDocument;
use DOMElement;

trait HtmlDocumentTrait
{
    /** @var DOMDocument $document */
    private $document;

    /**
     * @return DOMDocument
     */
    public function getDocument(): DOMDocument
    {
        return $this->document;
    }

    /**
     * @return DOMElement
     */
    public function getDocumentElement(): DOMElement
    {
        return $this->getDocument()
            ->documentElement;
    }

    /**
     * @param DOMElement $element
     * @return array
     */
    public function getChildNodes(DOMElement $element): array
    {
        /** @var array $result */
        $result = [];

        /** @var DOMNode $node */
        foreach ($element->childNodes as $node) {
            if ($node instanceof DOMElement) {
                $result[] = $node;
            }
        }

        return $result;
    }

    /**
     * @param DOMElement $element
     * @param string $tagName
     * @return array
     */
    public function getChildNodesByTagName(
        DOMElement $element,
        string $tagName
    ): array {
        /** @var array $result */
        $result = [];

        /** @var array $nodes */
        $nodes = $this->getChildNodes($element);

        /** @var DOMNode $node */
        foreach ($nodes as $node) {
            if ($node->tagName === $tagName) {
                $result[] = $node;
            }
        }

        return $result;
    }

    /**
     * @param DOMElement $element
     * @return DOMElement
     */
    public function importNode(DOMElement $element): DOMElement
    {
        return $this->getDocument()
            ->importNode($element, true);
    }

    /**
     * @param DOMElement $element
     * @param DOMElement|null $sibling
     * @return DOMElement
     */
    public function insertBefore(
        DOMElement $element,
        ?DOMElement $sibling = null
    ): DOMElement {
        /** @var DOMElement $parentNode */
        $parentNode = $sibling !== null
            ? $sibling->parentNode
            : $this->getDocumentElement();

        return $parentNode->insertBefore($element, $sibling);
    }

    /**
     * @param DOMElement $element
     * @param DOMElement|null $sibling
     * @return DOMElement
     */
    public function insertAfter(
        DOMElement $element,
        ?DOMElement $sibling = null
    ): DOMElement {
        /** @var DOMElement $parentNode */
        $parentNode = $sibling !== null
            ? $sibling->parentNode
            : $this->getDocumentElement();

        return $parentNode->insertBefore(
            $element,
            $sibling !== null ? $sibling->nextSibling : null
        );
    }

    /**
     * @param DOMElement $element
     * @param DOMElement|null $parent
     * @return DOMElement
     */
    public function appendNode(
        DOMElement $element,
        ?DOMElement $parent = null
    ): DOMElement {
        /** @var DOMElement $parentNode */
        $parentNode = $parent ?? $this->getDocumentElement();
        return $parentNode->appendChild($element);
    }

    /**
     * @param DOMElement[] $elements
     * @param DOMElement|null $parent
     * @return DOMElement[]
     */
    public function appendNodes(
        array $elements,
        ?DOMElement $parent = null
    ): array {
        /** @var DOMElement $parentNode */
        $parentNode = $parent ?? $this->getDocumentElement();

        /** @var DOMElement $element */
        foreach ($elements as $element) {
            $this->appendNode($element, $parentNode);
        }

        return $elements;
    }
}
