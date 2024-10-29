<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\XsNamespace as NS;
use SimpleSAML\XML\XsProcess;

use function array_diff;
use function array_php;
use function explode;
use function in_array;

/**
 * Abstract class representing the wildcard-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractWildcard extends AbstractAnnotated
{
    /**
     * Wildcard constructor
     *
     * @param string|null $namespace
     * @param \SimpleSAML\XML\XsProcess|null $processContents
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param string|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected NS|string|null $namespace = NS::ANY,
        protected ?XsProcess $processContents = XsProcess::STRICT,
        ?Annotation $annotation = null,
        ?string $id = null,
        array $namespacedAttributes = [],
    ) {
        if ($namespace instanceof NS) {
            Assert::oneOf($namespace, [NS::ANY, NS::OTHER], SchemaViolationException::class);
        } elseif (is_string($namespace)) {
            $values = explode(' ', $namespace);
            $values = array_diff($values, [NS::TARGET->value, NS::LOCAL->value]);
            Assert::allValidURI($values, SchemaViolationException::class);
        }

        parent::__construct($annotation, $id, $namespacedAttributes);
    }


    /**
     * Collect the value of the namespace-property
     *
     * @return \SimpleSAML\XML\XsNamespace|string|null
     */
    public function getNamespace(): NS|string|null
    {
        return $this->namespace;
    }


    /**
     * Collect the value of the processContents-property
     *
     * @return \SimpleSAML\XML\XsProcess|null
     */
    public function getProcessContents(): ?XsProcess
    {
        return $this->processContents;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return parent::isEmptyElement() &&
            empty($this->getNamespace()) &&
            empty($this->processContents());
    }


    /**
     * Create an instance of this object from its XML representation.
     *
     * @param \DOMElement $xml
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $namespace = self::getOptionalAttribute($xml, 'namespace', null);
        if (in_array($namespace, NS::cases(), true)) {
            $namespace = NS::from($namespace);
        }

        $processContents = self::getOptionalAttribute($xml, 'processContents', null);
        if ($processContents !== null) {
            $processContents = XsProcess::from($processContents);
        }

        $annotation = Annotation::getChildrenOfClass($xml);

        return new static(
            $namespace,
            $processContents,
            array_pop($annotation),
            self::getOptionalAttribute($xml, 'id', null),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this Wildcard to an XML element.
     *
     * @param \DOMElement $parent The element we should append this Wildcard to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getNamespace() !== null) {
            $e->setAttribute('namespace', is_string($this->getNamespace()) ? $this->getNamespace() : $this->getNamespace()->value);
        }

        if ($this->getProcessContents() !== null) {
            $e->setAttribute('processContents', $this->getProcessContents()->value);
        }

        return $e;
    }
}
