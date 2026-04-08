<?php

namespace App\Traits;

trait BuildCustomFormBuilderTrait
{
    protected function buildCustomFormBuilder(array $data = null, array $options = [])
    {
        $builder =  $this->createFormBuilder($data,$options);

        // check if options has 'fields' key and it's an array
        if (isset($options['fields']) && is_array($options['fields'])) {
            foreach ($options['fields'] as $field) {
                // check if field has 'name' and 'type' keys
                if (isset($field['name']) && isset($field['type'])) {
                    $fieldOptions = $field['options'] ?? [];
                    $builder->add($field['name'], $field['type'], $fieldOptions);
                }
            }
        }

        return $builder;
    }
}