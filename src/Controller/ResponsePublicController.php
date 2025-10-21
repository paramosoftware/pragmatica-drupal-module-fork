<?php


namespace Drupal\pragmatica\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Url;
use Drupal\pragmatica\Entity\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for displaying responses publicly.
 */
class ResponsePublicController extends ControllerBase
{

  protected $entityTypeManager;

  public function __construct(EntityTypeManagerInterface $entity_type_manager)
  {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Displays a single response entity.
   */
  public function item(Response $pragmatica_response): array
  {
//    todo: maybe move processing to entity to avoid duplication? (PragmaticaPublicController::75)
    $processed_response = [
      'label' => $pragmatica_response->label(),
      'url' => Url::fromRoute('pragmatica.public_response_item', ['pragmatica_response' => $pragmatica_response->id()])->toString(),
      'informant' => [
        'label' => 'Informante: ' . $pragmatica_response->get('informant_id')->entity->label(),
        'url' => Url::fromRoute('pragmatica.public_informant_item', ['pragmatica_informant' => $pragmatica_response->get('informant_id')->entity->id()])->toString(),
        'tooltip' => $pragmatica_response->get('informant_id')->entity->getLabelValueDisplay(),
      ],
      'situation' => [
        'label' => 'Situacão: ' . $pragmatica_response->get('situation_id')->entity->label(),
        'url' => Url::fromRoute('pragmatica.public_situation_item', ['pragmatica_situation' => $pragmatica_response->get('situation_id')->entity->id()])->toString(),
        'tooltip' => $pragmatica_response->get('situation_id')->entity->get('name')->value
      ],
      'tags' => $pragmatica_response->getLabels()
      ];

    $build['#theme'] = 'pragmatica_response_item';
    $build['#response'] = $processed_response;
    $build['#attached'] = [
      'library' => [
        'pragmatica/pragmatica_styles',
      ],
    ];

    return $build;
  }

  public function itemTitle(Response $pragmatica_response)
  {
    return $pragmatica_response->label();
  }
}
