<?php

namespace Drupal\pragmatica\Entity;

namespace Drupal\pragmatica\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;

/**
 * Defines the Selection entity.
 *
 * @ContentEntityType(
 *   id = "pragmatica_selection",
 *   label = @Translation("Seleção"),
 *   label_plural = @Translation("Seleções"),
 *   base_table = "pragmatica_selection",
 *   admin_permission = "administer pragmatica selection",
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\pragmatica\Form\SelectionForm",
 *       "edit" = "Drupal\pragmatica\Form\SelectionForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm"
 *     },
 *     "list_builder" = "Drupal\pragmatica\ListBuilder\SelectionListBuilder"
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name"
 *   },
 *   links = {
 *     "canonical" = "/admin/pragmatica/selection/{pragmatica_selection}",
 *     "add-form" = "/admin/pragmatica/selection/add",
 *     "edit-form" = "/admin/pragmatica/selection/{pragmatica_selection}/edit",
 *     "delete-form" = "/admin/pragmatica/selection/{pragmatica_selection}/delete",
 *     "collection" = "/admin/pragmatica/selection"
 *   }
 * )
 */
class Selection extends ContentEntityBase {
  use EntityChangedTrait;

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['guid'] = BaseFieldDefinition::create('string')
      ->setLabel(t('GUID'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 36)
      ->setDescription(t('Código único global (GUID) de identificação.'))
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 0,
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => 0,
      ]);

    $fields['type'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Tipo da seleção'))
      ->setRequired(TRUE)
      ->setSetting('target_type', 'pragmatica_selection_type')
      ->setDefaultValue(1)
      ->setDisplayOptions('form', [
        'type' => 'options_select',
        'weight' => 1,
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'entity_reference_label',
        'weight' => 1,
      ]);

    $fields['name'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Nome'))
      ->setRequired(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => 2,
      ])
      ->setDisplayOptions('view', [
        'type' => 'string',
        'label' => 'above',
        'weight' => 2,
      ]);

    $fields['description'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Descrição'))
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => 3,
      ])->
      setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'text_default',
        'weight' => 3,
      ]);

    $fields['source'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Fonte'))
      ->setSetting('target_type', 'pragmatica_source')
      ->setRequired(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 4,
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'entity_reference_label',
        'weight' => 4,
      ]);


    $fields['start_position'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Posição inicial do texto'))
      ->setDescription(t('A posição inicial do texto selecionado, em relação ao texto completo.'))
      ->setDisplayOptions('form', [
        'type' => 'number',
        'weight' => 5,
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'number',
        'weight' => 5,
      ]);

    $fields['end_position'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Posição final do texto'))
      ->setDescription(t('A posição final do texto selecionado, em relação ao texto completo.'))
      ->setDisplayOptions('form', [
        'type' => 'number',
        'weight' => 6,
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'number',
        'weight' => 6,
      ]);

    $fields['begin'] = BaseFieldDefinition::create('float')
      ->setLabel(t('Início do áudio'))
      ->setDescription(t('O início do áudio selecionado, em milissegundos.'))
      ->setDisplayOptions('form', [
        'type' => 'number',
        'step' => 'any',
        'weight' => 7,
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'number',
        'weight' => 7,
      ]);

    $fields['end'] = BaseFieldDefinition::create('float')
      ->setLabel(t('Fim do áudio'))
      ->setDescription(t('O fim do áudio selecionado, em milissegundos.'))
      ->setDisplayOptions('form', [
        'type' => 'number',
        'weight' => 8,
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'number',
        'weight' => 8,
      ]);

    // Transform sync points in entity references to a SyncPoint entity.
    $fields['from_sync_point'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Ponto de sincronização inicial'))
      ->setSettings(['max_length' => 36])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 9,
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => 9,
      ]);

    $fields['to_sync_point'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Ponto de sincronização final'))
      ->setSettings(['max_length' => 36])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 9,
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => 9,
      ]);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Criado em'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Modificado em'));

    return $fields;
  }
}
