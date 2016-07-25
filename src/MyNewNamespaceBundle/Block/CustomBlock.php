<?php
namespace MyNewNamespaceBundle\Block;

use EzSystems\LandingPageFieldTypeBundle\Exception\InvalidBlockAttributeException;
use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockDefinition;
use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockAttributeDefinition;
use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\AbstractBlockType;
use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\BlockValue;

class CustomBlock extends AbstractBlockType
{
    /*
     * With this method you can return values that will be used in the template as variables.
     */
    public function getTemplateParameters(BlockValue $blockValue)
    {
        return [
            'block' => json_encode($blockValue->getAttributes())
        ];
    }

    /*
     * Creates block definition with fields
     */
    public function createBlockDefinition()
    {
        return new BlockDefinition(
            'custom', // Block type (unique)
            'Custom Block', // Name of block
            'default',
            'bundles/ezsystemslandingpagefieldtype/images/thumbnails/tag.svg', // block thumbnail; will be used in the eZ Studio blocks sidebar
            [], // extra views - the hardcoded template
            [
                new BlockAttributeDefinition(
                    'content', // Attribute's ID (unique)
                    'Content', // Attribute' name
                    'text', // Attribute's type
                    '/[^\\s]/', // regex for frontend validation
                    'The content value should be a text', // regex validation fail message
                    true, // is field required?
                    false, // should this attribute input be displayed inline to the previous?
                    [], // default value
                    [] // available options (only for select and multiple field types)
                ),

                new BlockAttributeDefinition(
                    'contentStyle',
                    'Content Style',
                    'select',
                    '',
                    'Please, select a style',
                    false,
                    false,
                    ['default'],
                    [
                        'default'   => 'Default style',
                        'flat'      => 'Flat style',
                        'rounded'   => 'Rounded style'
                    ]
                ),
            ]
        );
    }

    /*
     * Validates user input from the block configuration form
     */
    public function checkAttributesStructure(array $attributes)
    {
        if (!isset($attributes['content'])) {
            throw new InvalidBlockAttributeException(
                $this->getBlockDefinition()->getName(),
                'content',
                'Content must be set.'
            );
        }
    }
}
