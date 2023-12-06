<?php

namespace Drupal\chatgpt_plugin\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\chatgpt_plugin\GPTApiService;

/**
 * Function to create the ChatGPT Search popup.
 */
class ChatGPTForm extends FormBase {

  /**
   * The default http client.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * The custom GPT API service.
   *
   * @var \Drupal\chatgpt_plugin\GPTApiService
   */
  protected $gptApi;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('http_client'),
      $container->get('chatgpt_plugin.gpt_api'),
    );
  }

  /**
   * Constructor of the class.
   *
   * @param \GuzzleHttp\ClientInterface $http_client
   *   An http client.
   * @param \Drupal\chatgpt_plugin\GPTApiService $gpt_api
   *   Our custom GPT API service.
   */
  public function __construct(ClientInterface $http_client, GPTApiService $gpt_api) {
    $this->httpClient = $http_client;
    $this->gptApi = $gpt_api;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'chatgpt_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['chatgpt_search'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Search content in ChatGPT'),
      '#maxlength' => 1024,
    ];

    $form['chatgpt_submit'] = [
      '#type' => 'button',
      '#value' => 'Search',
      '#ajax' => [
        'callback' => '::chatgptSearchResult',
        'effect' => 'fade',
        'event' => 'click',
        'progress' => [
          'type' => 'throbber',
          'message' => $this->t('Getting Result from OpenAI ChatGPT...'),
        ],
      ],
    ];

    $form['chatgpt_result'] = [
      '#type' => 'markup',
      '#title' => $this->t('ChatGPT Result'),
      '#markup' => '<div id="chatgpt-result"></div>',
    ];

    return $form;
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

  }

  /**
   * Ajax callback function to call the ChatGPT API.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function chatgptSearchResult(array &$form, FormStateInterface $form_state) {
    $ajax_response = new AjaxResponse();
    $prompt_text = $form_state->getValue('chatgpt_search');

    // Calling our custom GPT API Service..
    try {
      $response = $this->gptApi->getGptResponse($prompt_text);
    }
    catch (GuzzleException $exception) {
      // Error handling for GPT Service call.
      $error_msg = $exception->getMessage();
      $ajax_response->addCommand(new HtmlCommand('#chatgpt-result', $error_msg));
      return $ajax_response;
    }

    // Processing success response data.
    $ajax_response->addCommand(new HtmlCommand('#chatgpt-result', nl2br($response)));
    return $ajax_response;
  }

}
