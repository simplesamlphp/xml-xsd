<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XML\XsNamespace as NS;
use SimpleSAML\XML\XsProcess;

use function array_column;
use function array_pop;
use function in_array;
use function intval;
use function is_int;
use function strval;

/**
 * Class representing the Any element
 *
 * @package simplesamlphp/xml-xsd
 */
final class Any extends AbstractWildcard implements SchemaValidatableElementInterface
{
    use OccursTrait;
    use SchemaValidatableElementTrait;

    /** @var string */
    public const LOCALNAME = 'any';


    /**
     * Wildcard constructor
     *
     * @param string|null $namespace
     * @param \SimpleSAML\XML\XsProcess|null $processContents
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param string|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     * @param int|null $minOccurs
     * @param int|string|null $maxOccurs
     */
    public function __construct(
        protected NS|string|null $namespace = NS::ANY,
        protected ?XsProcess $processContents = XsProcess::STRICT,
        ?Annotation $annotation = null,
        ?string $id = null,
        array $namespacedAttributes = [],
        ?int $minOccurs = 1,
        int|string|null $maxOccurs = 1,
    ) {
        parent::__construct($namespace, $processContents, $annotation, $id, $namespacedAttributes);

        $this->setMinOccurs($minOccurs);
        $this->setMaxOccurs($maxOccurs);
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return parent::isEmptyElement() &&
            empty($this->getMinOccurs()) &&
            empty($this->getMaxOccurs());
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
        if (in_array($namespace, array_column(NS::cases(), 'value'), true)) {
            $namespace = NS::from($namespace);
        }

        $processContents = self::getOptionalAttribute($xml, 'processContents', null);
        if ($processContents !== null) {
            $processContents = XsProcess::from($processContents);
        }

        $annotation = Annotation::getChildrenOfClass($xml);

        $minOccurs = self::getOptionalIntegerAttribute($xml, 'minOccurs', null);
        $maxOccurs = self::getOptionalAttribute($xml, 'maxOccurs', null);
        if (!in_array($maxOccurs, [null, 'unbounded'])) {
            $maxOccurs = intval($maxOccurs);
        }

        return new static(
            $namespace,
            $processContents,
            array_pop($annotation),
            self::getOptionalAttribute($xml, 'id', null),
            self::getAttributesNSFromXML($xml),
            $minOccurs,
            $maxOccurs,
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

        if ($this->getMinOccurs() !== null) {
            $e->setAttribute('minOccurs', strval($this->getMinOccurs()));
        }

        if ($this->getMaxOccurs() !== null) {
            $maxOccurs = $this->getMaxOccurs();
            $e->setAttribute('maxOccurs', is_int($maxOccurs) ? strval($maxOccurs) : $maxOccurs);
        }

        return $e;
    }
}
