<?php

namespace Drupal\node_revision_delete;

use Drupal\node\Entity\Node;

/**
 * Methods for delete revisions in a batch.
 */
class NodeRevisionDeleteBatch {

  /**
   * Delete revision.
   *
   * Once the revision is deleted the context is updated with the total number
   * of revisions deleted and the node object.
   *
   * @param \Drupal\node\Entity\Node|int $revision
   *   The revision to delete.
   * @param bool $dry_run
   *   Indicate if we need to delete or not the revision. TRUE for test purpose
   *   FALSE to delete the revision.
   * @param int $total
   *   The total number of items to be processed.
   * @param mixed $context
   *   The context of the current batch.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public static function deleteRevision($revision, bool $dry_run, int $total, &$context): void {
    $node_storage = \Drupal::entityTypeManager()->getStorage('node');
    /** @var \Drupal\node\NodeInterface $node */
    $node = $revision instanceof Node ? $revision : $node_storage->loadRevision($revision);

    // Count the number of revisions deleted.
    $revisions_count = $context['results']['revisions'] ?? 0;
    $context['results']['revisions'] = ++$revisions_count;

    // Checking if this is a dry run or we really need to delete the variable.
    if (!$dry_run) {
      // Delete the revision.
      $node_storage->deleteRevision($node->getRevisionId());
    }

    // Adding a message for the actual revision being deleted.
    $message = t('@current / @total - Revision @rid of node @nid - @lang - @title', [
      '@rid' => $node->getRevisionId(),
      '@nid' => $node->id(),
      '@lang' => $node->language()->getId(),
      '@title' => $node->label(),
      '@current' => $revisions_count,
      '@total' => $total,
    ]);
    $context['message'] = $dry_run
      ? '[DRY-RUN] - ' . $message
      : $message;
  }

  /**
   * Actions on finishing the batch.
   *
   * @param bool $success
   *   The flag to identify if batch has successfully run or not.
   * @param array $results
   *   The results from running context.
   * @param array $operations
   *   The array of operations remained unprocessed.
   */
  public static function finish(bool $success, array $results, array $operations): void {
    $messenger = \Drupal::messenger();
    $logger = \Drupal::logger('node_revision_delete');
    $success_message = '';

    if ($success) {
      if (isset($results['revisions'])) {
        $success_message = \Drupal::translation()->formatPlural(
          $results['revisions'],
          'One revision has been deleted.',
          'Deleted @count revisions.',
          ['@total' => $results['revisions']]
        );
      }

      if (!empty($success_message)) {
        $logger->notice($success_message);
        $messenger->addMessage($success_message);
      }
    }
    else {
      // An error occurred.
      // $operations contains the operations that remained unprocessed.
      $error_operation = reset($operations);
      $message = t('An error occurred while processing %error_operation with arguments: @arguments', [
        '%error_operation' => $error_operation[0],
        '@arguments' => print_r($error_operation[1], TRUE),
      ]);
      $logger->error($message);
      $messenger->addError($message);
    }
  }

}
