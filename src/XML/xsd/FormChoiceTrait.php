<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

/**
 * Trait grouping common functionality for elements that can hold a formChoice attribute.
 *
 * @package simplesamlphp/xml-xsd
 */
trait FormChoiceTrait
{
    /**
     * The formChoice.
     *
     * @var \SimpleSAML\XSD\XML\xsd\FormChoiceEnum
     */
    protected FormChoiceEnum $formChoice;


    /**
     * Collect the value of the formChoice-property
     *
     * @return \SimpleSAML\XSD\XML\xsd\FormChoiceEnum
     */
    public function getFormChoice(): FormChoiceEnum
    {
        return $this->formChoice;
    }


    /**
     * Set the value of the formChoice-property
     *
     * @param \SimpleSAML\XSD\XML\xsd\FormChoiceEnum $formChoice
     */
    protected function setFormChoice(FormChoiceEnum $formChoice): void
    {
        $this->formChoice = $formChoice;
    }
}
