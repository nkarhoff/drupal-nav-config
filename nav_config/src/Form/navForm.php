<?php


namespace Drupal\nav_config\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;
use Drupal\Core\File\FileSystemInterface;

class navForm extends ConfigFormBase {
  public function getFormId() {
    // Unique ID of the form.
    return 'nav_form';
  }

  // Set up configs for module
  protected function getEditableConfigNames() {
    return [
      'nav_config.settings',
    ];
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    // Create a $form API array.

    // Get config variables and store them in a variable if they exist as default values for the form
    $nav_selection = \Drupal::config('nav_config.settings')->get('nav_selection');

    // Get config variables
    $config = $this->config('nav_config.settings');

    // Nav Selection
    $form['nav_selection'] = array(
      '#type' => 'radios',
      '#title' => t('Navigation Options'),
      '#options' => array('Hamburger Menu' => 'Hamburger', 'Basic Navigation' => 'Basic Navigation'),
      '#default_value' => $nav_selection
    );

    return parent::buildForm($form, $form_state);
  }


  // Submitting the form variables to the config (there is no more function in Drupal 8 that does this for you upon a config form submission)
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::service('config.factory')->getEditable('nav_config.settings');

    $config->set('nav_selection', $form_state->getValue('nav_selection'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
