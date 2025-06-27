<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\XML\Type\{IDValue, NCNameValue, QNameValue};
use SimpleSAML\XSD\Type\{MinOccursValue, MaxOccursValue};

use function strval;

/**
 * Abstract class representing the group-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractGroup extends AbstractAnnotated
{
    use DefRefTrait;
    use OccursTrait;

    /**
     * Group constructor
     *
     * @param \SimpleSAML\XML\Type\NCNameValue|null $name
     * @param \SimpleSAML\XML\Type\QNameValue|null $reference
     * @param \SimpleSAML\XSD\Type\MinOccursValue|null $minOccurs
     * @param \SimpleSAML\XSD\Type\MaxOccursValue|null $maxOccurs
     * @param array<\SimpleSAML\XSD\XML\xsd\ParticleInterface> $particles
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        ?NCNameValue $name = null,
        ?QNameValue $reference = null,
        ?MinOccursValue $minOccurs = null,
        ?MaxOccursValue $maxOccurs = null,
        protected array $particles = [],
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct($annotation, $id, $namespacedAttributes);

        $this->setName($name);
        $this->setReference($reference);
        $this->setMinOccurs($minOccurs);
        $this->setMaxOccurs($maxOccurs);
    }


    /**
     * Collect the value of the particles-property
     *
     * @return array<\SimpleSAML\XSD\XML\xsd\ParticleInterface>
     */
    public function getParticles(): array
    {
        return $this->particles;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return parent::isEmptyElement() &&
            empty($this->getParticles()) &&
            empty($this->getName()) &&
            empty($this->getReference()) &&
            empty($this->getMinOccurs()) &&
            empty($this->getMaxOccurs());
    }


    /**
     * Add this Group to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this Group to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getName() !== null) {
            $e->setAttribute('name', strval($this->getName()));
        }

        if ($this->getReference() !== null) {
            $e->setAttribute('ref', strval($this->getReference()));
        }

        if ($this->getMinOccurs() !== null) {
            $e->setAttribute('minOccurs', strval($this->getMinOccurs()));
        }

        if ($this->getMaxOccurs() !== null) {
            $e->setAttribute('maxOccurs', strval($this->getMaxOccurs()));
        }

        foreach ($this->getParticles() as $particle) {
            $particle->toXML($e);
        }

        return $e;
    }
}
