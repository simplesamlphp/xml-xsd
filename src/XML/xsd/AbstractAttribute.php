<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\XML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Type\{IDValue, NCNameValue, QNameValue};

use function strval;

/**
 * Abstract class representing the attribute-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractAttribute extends AbstractAnnotated
{
    use DefRefTrait;
    use FormChoiceTrait;


    /**
     * Attribute constructor
     *
     * @param \SimpleSAML\XML\Type\NCNameValue $name
     * @param \SimpleSAML\XML\Type\QNameValue $reference
     * @param string $type
     * @param string|null $use
     * @param string|null $default
     * @param string|null $fixed
     * @param \SimpleSAML\XSD\XML\xsd\FormChoiceEnum|null $formChoice
     * @param array $simpleType
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        NCNameValue $name,
        QNameValue $reference,
        protected string $type,
        protected ?string $use = null,
        protected ?string $default = null,
        protected ?string $fixed = null,
        protected ?FormChoiceEnum $formChoice = null,
        protected array $simpleType = [],
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        Assert::validQName($type, SchemaViolationException::class);
        Assert::nullOrOneOf($use, ['optional', 'prohibited', 'required'], SchemaViolationException::class);

        parent::__construct($annotation, $id, $namespacedAttributes);

        $this->setName($name);
        $this->setReference($reference);
        $this->setFormChoice($formChoice);
    }


    /**
     * Collect the value of the simpleType-property
     *
     * @return array
     */
    public function getSimpleType(): array
    {
        return $this->simpleType;
    }


    /**
     * Collect the value of the type-property
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }


    /**
     * Collect the value of the use-property
     *
     * @return string|null
     */
    public function getUse(): ?string
    {
        return $this->use;
    }


    /**
     * Collect the value of the default-property
     *
     * @return string|null
     */
    public function getDefault(): ?string
    {
        return $this->default;
    }


    /**
     * Collect the value of the fixed-property
     *
     * @return string|null
     */
    public function getFixed(): ?string
    {
        return $this->fixed;
    }


    /**
     * Add this Attribute to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this facet to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        $e->setAttribute('name', strval($this->getName()));
        $e->setAttribute('reference', strval($this->getReference()));
        $e->setAttribute('type', $this->getType());

        if ($this->getUse() !== null) {
            $e->setAttribute('use', $this->getUse());
        }

        if ($this->getDefault() !== null) {
            $e->setAttribute('default', $this->getDefault());
        }

        if ($this->getFixed() !== null) {
            $e->setAttribute('fixed', $this->getFixed());
        }

        if ($this->getFormChoice() !== null) {
            $e->setAttribute('formChoice', $this->getFormChoice()->value);
        }

        foreach ($this->getSimpleType() as $st) {
            $st->toXML($e);
        }

        return $e;
    }
}
