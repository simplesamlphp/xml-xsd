<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

/**
 * Trait grouping common functionality for elements that are part of the xs:complexTypeModel group.
 *
 * @package simplesamlphp/xml-xsd
 */
trait ComplexTypeModelTrait
{
    use AttrDeclsTrait;
    use TypeDefParticleTrait;

    /**
     * The content.
     *
     * @var \SimpleSAML\XSD\XML\xsd\SimpleContent|\SimpleSAML\XSD\XML\xsd\ComplexContent|null
     */
    protected SimpleContent|ComplexContent|null $content = null;


    /**
     * Collect the value of the content-property
     *
     * @return \SimpleSAML\XSD\XML\xsd\SimpleContent|\SimpleSAML\XSD\XML\xsd\ComplexContent|null
     */
    public function getContent(): SimpleContent|ComplexContent|null
    {
        return $this->content;
    }


    /**
     * Set the value of the content-property
     *
     * @param \SimpleSAML\XSD\XML\xsd\SimpleContent|\SimpleSAML\XSD\XML\xsd\ComplexContent|null $content
     */
    protected function setContent(SimpleContent|ComplexContent|null $content = null): void
    {
        $this->content = $content;
    }
}
