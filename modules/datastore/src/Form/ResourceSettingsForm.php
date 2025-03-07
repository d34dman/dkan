<?php

namespace Drupal\datastore\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * DKAN resource settings form.
 *
 * @package Drupal\datastore\Form
 * @codeCoverageIgnore
 */
class ResourceSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'resource_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['datastore.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['resources'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Purge dataset resources'),
      '#description' => $this->t('Upon dataset publication, delete older revision resources if they are no longer necessary.'),
    ];
    $form['resources']['purge_table'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Datastore table'),
      '#default_value' => $this->config('datastore.settings')->get('purge_table'),
    ];
    $form['resources']['purge_file'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('File'),
      '#default_value' => $this->config('datastore.settings')->get('purge_file'),
    ];
    $form['delete_local_resource'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Delete local resource'),
      '#default_value' => $this->config('datastore.settings')->get('delete_local_resource'),
      '#description' => $this->t('Delete local copy of remote files after the datastore import is complete'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('datastore.settings')
      ->set('purge_table', $form_state->getValue('purge_table'))
      ->set('purge_file', $form_state->getValue('purge_file'))
      ->set('delete_local_resource', $form_state->getValue('delete_local_resource'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
