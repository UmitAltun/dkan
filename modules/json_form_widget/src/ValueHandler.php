<?php

namespace Drupal\json_form_widget;

/**
 * Class ValueHandler.
 */
class ValueHandler {

  /**
   * Flatten values.
   */
  public function flattenValues($formValues, $property, $schema) {
    $data = [];

    switch ($schema->type) {
      case 'string':
        $data = $this->handleStringValues($formValues, $property);
        break;

      case 'object':
        $data = $this->handleObjectValues($formValues[$property][$property], $property, $schema);
        break;

      case 'array':
        $data = $this->handleArrayValues($formValues, $property, $schema);
        break;
    }
    return $data;
  }

  /**
   * Flatten values for string properties.
   */
  public function handleStringValues($formValues, $property) {
    if (!empty($formValues[$property])) {
      return $formValues[$property];
    }
    return FALSE;
  }

  /**
   * Flatten values for object properties.
   */
  public function handleObjectValues($formValues, $property, $schema) {
    if (!isset($formValues)) {
      return FALSE;
    }

    $properties = array_keys((array) $schema->properties);
    $data = FALSE;
    foreach ($properties as $sub_property) {
      $value = $this->flattenValues($formValues, $sub_property, $schema->properties->$sub_property);
      if ($value) {
        $data[$sub_property] = $value;
      }
    }
    return $data;
  }

  /**
   * Flatten values for array properties.
   */
  public function handleArrayValues($formValues, $property, $schema) {
    $data = FALSE;
    $subschema = $schema->items;
    if ($subschema->type === "object") {
      return $this->getObjectInArrayData($formValues, $property, $subschema);
    }

    foreach ($formValues[$property][$property] as $key => $value) {
      if (!empty($value)) {
        $data[$key] = $value;
      }
    }
    return $data;
  }

  /**
   * Flatten values for objects in arrays.
   */
  private function getObjectInArrayData($formValues, $property, $schema) {
    $data = [];
    foreach ($formValues[$property][$property] as $key => $item) {
      $value = $this->handleObjectValues($formValues[$property][$property][$key][$property], $property, $schema);
      if ($value) {
        $data[$key] = $value;
      }
    }
    return $data;
  }

}
