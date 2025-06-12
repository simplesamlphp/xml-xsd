<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

enum NamespaceEnum: string
{
    case Any = '##any';
    case Local = '##local';
    case Other = '##other';
    case TargetNamespace = '##targetNamespace';
}
