<?php
namespace Drupal\nik_twig_extensions\TwigExtension;

class NikFilters extends \Twig_Extension {

    public function getFilters() {
        return [
            new \Twig_SimpleFilter('shuffle', array(
                $this,
                'shuffle'
            ))
        ];
    }

    public function getName() {
        return 'nik_twig_extensions.twig_extension';
    }

    public static function shuffle(array $string) {
        shuffle($string);
        return $string;
    }

}
