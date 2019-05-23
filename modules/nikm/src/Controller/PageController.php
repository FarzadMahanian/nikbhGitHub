<?php

/**
 * Created by PhpStorm.
 * User: payam
 * Date: 5/16/2017 AD
 * Time: 2:47 PM
 */

namespace Drupal\nikm\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\Entity;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PageController extends ControllerBase {

    private function getCurrentLanguage() {
        return \Drupal::languageManager()
            ->getCurrentLanguage()
            ->getId();
    }

    public function getProductsPage() {
        $lang = $this->getCurrentLanguage();
        $q = \Drupal::entityQuery('node')
            ->condition('status', 1)
            ->condition('type', 'product')
            ->addTag('random')
            ->range(0, 1);
        $nids = $q->execute();
        $nodes = Node::loadMultiple($nids);
        $node = NULL;
        foreach ($nodes as $node) {
            $node = $node->get('field_main_picture')->entity->uri->value;
        }

        $all_types = [];
        $parentTerms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('product_types', 0, 1);
        foreach ($parentTerms as $parent) {
            $parentTerm = Term::load($parent->tid);
            $parentLangTerm = \Drupal::service('entity.repository')->getTranslationFromContext($parentTerm, $lang);
            $all_types[$parentLangTerm->id()] = [
                'id' => $parentLangTerm->id(),
                'title' => $parentLangTerm->toLink()->getText(),
                'link' => \Drupal::l($parentLangTerm->toLink()->getText(), $parentLangTerm->toUrl()),
                'description' => $parentLangTerm->get('description')->getValue()[0]['value']
            ];

            $children = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('product_types', $parent->tid, null);
            if (count($children) > 0) {
                foreach ($children as $child) {
                    $childTerm = Term::load($child->tid);
                    $childLangTerm = \Drupal::service('entity.repository')->getTranslationFromContext($childTerm, $lang);
                    $all_types[$parentLangTerm->id()]['children'][] = [
                        'id' => $childLangTerm->id(),
                        'title' => $childLangTerm->toLink()->getText(),
                        'link' => \Drupal::l($childLangTerm->toLink()->getText(), $childLangTerm->toUrl()),
                        'description' => $childLangTerm->get('description')->getValue()[0]['value'],
                        'parentName' => $parentLangTerm->toLink()->getText()
                    ];
                }
            } else {
                $all_types[$parentLangTerm->id()]['children'] = NULL;
            }
        }

        return [
            '#theme' => 'products',
            '#all_types' => $all_types,
            '#picture' => $node
        ];
    }

    public function sendContact(Request $request) {
        $json = json_decode($request->getContent());
        $contactMailTemplate = [
            '#theme' => 'contactEmail',
            '#formParams' => $json
        ];
        $mailStatus = $this->sendMail($contactMailTemplate, 'Contact', 'Contact ' . $json->name);
        $response = new JsonResponse($json, Response::HTTP_OK);
        if (!$mailStatus) {
            $response = new JsonResponse($json, Response::HTTP_BAD_REQUEST);
        }
        return $response;
    }

    public function joinUs(Request $request) {
        $json = json_decode($request->getContent());
        $mailTemplate = [
            '#theme' => 'joinEmail',
            '#formParams' => $json
        ];
        $mailStatus = $this->sendMail($mailTemplate, 'Join', 'Join ' . $json->name);
        $response = new JsonResponse($json, Response::HTTP_OK);
        if (!$mailStatus) {
            $response = new JsonResponse($json, Response::HTTP_BAD_REQUEST);
        }
        return $response;
    }

    public function sendService(Request $request) {
        $json = json_decode($request->getContent());
        $mailTemplate = [
            '#theme' => strtolower($json->cat) . 'Email',
            '#formParams' => $json
        ];
        $mailStatus = $this->sendMail($mailTemplate, 'Service', 'Sale Service ' . '[' . $json->cat . ']');
        $response = new JsonResponse($json, Response::HTTP_OK);
        if (!$mailStatus) {
            $response = new JsonResponse($json, Response::HTTP_BAD_REQUEST);
        }
        return $response;
    }

    private function sendMail($emailTemplate, $category, $title) {
        $q = \Drupal::entityQuery('node')
            ->condition('type', 'configuration')
            ->range(0, 1);
        $nids = $q->execute();
        $nodes = Node::loadMultiple($nids);
        $emailTo = NULL;
        $emailFrom = NULL;
        foreach ($nodes as $node) {
            $emailFrom = $node->get('field_website_email_from')->value;
            $emailTo = $node->get('field_website_email_to')->value;
        }

        $mailManager = \Drupal::service('plugin.manager.mail');
        $module = 'nikm';
        $key = $category;
        $to = $emailTo;
        $params['from'] = $emailFrom;
        $params['message'] = \Drupal::service('renderer')
            ->render($emailTemplate);
        $params['title'] = $title;
        $langcode = \Drupal::currentUser()->getPreferredLangcode();
        $send = TRUE;
        $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);

        if ($result['result'] !== TRUE) {
            $message = t('There was a problem sending @category email notification to @email with title "@title".',
                array(
                    '@category' => $category,
                    '@email' => $to,
                    '@title' => $title
                )
            );
            \Drupal::logger('nikm')->error($message);
            return FALSE;
        }

        $message = t('A @category email notification has been sent to @email with title @title.',
            array(
                '@category' => $category,
                '@email' => $to,
                '@title' => $title
            )
        );
        \Drupal::logger('nimk')->notice($message);
        return TRUE;
    }

    public function getSalesServicePage() {
        $lang = $this->getCurrentLanguage();
        $q = \Drupal::entityQuery('node')
            ->condition('type', 'product');
        $nids = $q->execute();
        $nodes = Node::loadMultiple($nids);
        $products = [];
        foreach ($nodes as $node) {
            $node = $node->getTranslation($lang);
            $products[] = $node->getTitle();
        }
        return [
            '#theme' => 'salesService',
            '#products' => $products
        ];
    }

    public function getJoinPage() {
        return [
            '#theme' => 'joinpage'
        ];
    }

}
