<?php

namespace Drupal\chatgpt_plugin\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Function to create the ChatGPT Config Form.
 */
class ChatGPTConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'chatgpt_plugin.adminsettings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'chatgpt_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('chatgpt_plugin.adminsettings');

    $form['chatgpt_setting_compare_tool'] = [
      '#type' => 'markup',
      '#markup' => '<a id="chatgpt-tool" href="https://gpttools.com/comparisontool" target="_blank">Click here to access the ChatGPT API setting comparison tool</a>',
    ];

    $gpt_model_options = [
      'gpt3' => 'GPT 3',
      'chatgpt' => 'GPT 3.5 or ChatGPT',
    ];

    $form['gpt_model_version'] = [
      '#type' => 'select',
      '#title' => $this->t('Select GPT Model Version'),
      '#description' => $this->t('Select the version of the GPT model you want to leverage.'),
      '#options' => $gpt_model_options,
      '#default_value' => $config->get('gpt_model_version'),
      '#required' => TRUE,
    ];

    $form['completion_endpoint'] = [
      '#type' => 'textfield',
      '#title' => $this->t('GPT3 Completion API Endpoint'),
      '#description' => $this->t('Please provide the GPT3 Completion API Endpoint here.'),
      '#default_value' => $config->get('completion_endpoint') ? $config->get('completion_endpoint') : 'https://api.openai.com/v1/completions',
      '#states' => [
        // Only show this field when the value is gpt3.
        'visible' => [
          ':input[name="gpt_model_version"]' => ['value' => 'gpt3'],
        ],
      ],
      '#required' => TRUE,
    ];

    $form['chatgpt_endpoint'] = [
      '#type' => 'textfield',
      '#title' => $this->t('GPT3.5 Chat API Endpoint'),
      '#description' => $this->t('Please provide the GPT3 Completion API Endpoint here.'),
      '#default_value' => $config->get('chatgpt_endpoint') ? $config->get('chatgpt_endpoint') : 'https://api.openai.com/v1/chat/completions',
      '#states' => [
        // Only show this field when the value is gpt_3.5.
        'visible' => [
          ':input[name="gpt_model_version"]' => ['value' => 'chatgpt'],
        ],
      ],
      '#required' => TRUE,
    ];

    $form['gpt3_model'] = [
      '#type' => 'textfield',
      '#title' => $this->t('GPT3 API Model'),
      '#description' => $this->t('Please provide the GPT3 API Model here like text-curie-001. List of all models can be found
                        <a href="https://beta.openai.com/docs/models/gpt-3" target="_blank"><b>Here</b></a>'),
      '#default_value' => $config->get('gpt3_model'),
      '#states' => [
        // Only show this field when the value is gpt_3.
        'visible' => [
          ':input[name="gpt_model_version"]' => ['value' => 'gpt3'],
        ],
      ],
      '#required' => TRUE,
    ];

    $form['chatgpt_model'] = [
      '#type' => 'textfield',
      '#title' => $this->t('GPT3.5 API Model'),
      '#description' => $this->t('Please provide the ChatGPT API Model here. List of models are -
                        gpt-3.5-turbo and gpt-3.5-turbo-0301'),
      '#default_value' => $config->get('chatgpt_model'),
      '#states' => [
        // Only show this field when the value is gpt_3.5.
        'visible' => [
          ':input[name="gpt_model_version"]' => ['value' => 'chatgpt'],
        ],
      ],
      '#required' => TRUE,
    ];

    $form['dalle_endpoint'] = [
      '#type' => 'textfield',
      '#title' => $this->t('DALL.E API Endpoint'),
      '#description' => $this->t('Please provide the DAll.E API Endpoint here.'),
      '#default_value' => $config->get('dalle_endpoint') ? $config->get('dalle_endpoint') : 'https://api.openai.com/v1/images/generations',
      '#required' => TRUE,
    ];

    $form['chatgpt_token'] = [
      '#type' => 'textfield',
      '#title' => $this->t('ChatGPT Access Token'),
      '#description' => $this->t('Please provide the ChatGPT Access Token here.'),
      '#default_value' => $config->get('chatgpt_token'),
      '#required' => TRUE,
    ];

    $form['chatgpt_max_token'] = [
      '#type' => 'textfield',
      '#title' => $this->t('ChatGPT API Max Token'),
      '#description' => $this->t('Please provide the ChatGPT max token here to limit the output words. Max token is the 
                        limit <br>of tokens combining both input prompt and output text. 1 token is approx 4 chars in English.
                        <br>You can use this <a href="https://platform.openai.com/tokenizer" target="_blank"><b>Tokenizer Tool</b></a> 
                        to count number of tokens for your text.'),
      '#default_value' => $config->get('chatgpt_max_token'),
      '#required' => TRUE,
    ];

    $form['chatgpt_temperature'] = [
      '#type' => 'textfield',
      '#title' => $this->t('ChatGPT API Temperature'),
      '#description' => $this->t('Please provide the Temperature value here. Please set it to 0.9 for most creative output.'),
      '#default_value' => $config->get('chatgpt_temperature'),
    ];

    return parent::buildForm($form, $form_state);

  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('chatgpt_plugin.adminsettings')
      ->set('gpt_model_version', $form_state->getValue('gpt_model_version'))
      ->set('completion_endpoint', $form_state->getValue('completion_endpoint'))
      ->set('chatgpt_endpoint', $form_state->getValue('chatgpt_endpoint'))
      ->set('gpt3_model', $form_state->getValue('gpt3_model'))
      ->set('chatgpt_model', $form_state->getValue('chatgpt_model'))
      ->set('dalle_endpoint', $form_state->getValue('dalle_endpoint'))
      ->set('chatgpt_token', $form_state->getValue('chatgpt_token'))
      ->set('chatgpt_temperature', $form_state->getValue('chatgpt_temperature'))
      ->set('chatgpt_max_token', $form_state->getValue('chatgpt_max_token'))
      ->save();
  }

}
