<?php
/**
 * Created by PhpStorm.
 * User: Diego Cortés
 * Date: 2019-06-13
 * Time: 07:30
 */

namespace Drupal\custom_poll_d8\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;
/**
 * Class MydataForm.
 *
 * @package Drupal\mydata\Form
 */
class PollForm extends FormBase {
    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'custom_poll_form';
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['name'] = array(
            '#type' => 'textfield',
            '#title' => t('Nombre:'),
            '#required' => TRUE,
            '#default_value' => '',
        );
        $form['email'] = array(
            '#type' => 'email',
            '#title' => t('Email:'),
            '#required' => TRUE,
            '#default_value' => '',
        );
        $form['phone'] = array(
            '#type' => 'textfield',
            '#title' => t('Número de Teléfono:'),
            '#default_value' => '',
        );
        $form['question1'] = array (
            '#type' => 'select',
            '#title' => t('¿Cuál considera es el método de transporte más eficiente para Bogotá?'),
            '#options' => array(
                '' => '-- select --',
                'transmilenio' => t('Transmilenio'),
                'taxi' => t('Taxi'),
                'bicicleta' => t('Bicicleta'),
                'otro' => t('Otro'),
                '#default_value' => '',
            ),
        );
        $form['question2'] = array (
            '#type' => 'select',
            '#title' => t('¿Considera que el sistema de transporte ha mejorado en Bogotá?'),
            '#options' => array(
                '' => '-- select --',
                'si' => t('Si'),
                'no' => t('No'),
                '#default_value' => '',
            ),
        );
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => 'save',
        ];
        return $form;
    }
    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        $email = $form_state->getValue('email');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $form_state->setErrorByName('name', $this->t('correo electrónico invalido'));
        }
        if (strlen($form_state->getValue('phone')) < 7 ) {
            $form_state->setErrorByName('phone', $this->t('tu número debe tener por lo menos 7 dígitos'));
        }
        parent::validateForm($form, $form_state);
    }
    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $values     = $form_state->getValues();
        $name       = $values['name'];
        $email      = $values['email'];
        $phone      = $values['phone'];
        $question1  = $values['question1'];
        $question2  = $values['question2'];

        $fields = [
            'name'      => $name,
            'email'     => $email,
            'phone'     => $phone,
            'question1' => $question1,
            'question2' => $question2,
        ];

        $query = \Drupal::database();
        $query ->insert('custom_poll_d8_poll')
            ->fields($fields)
            ->execute();
        $response = new RedirectResponse("/custom-poll/thank-you");
        $response->send();
    }
}