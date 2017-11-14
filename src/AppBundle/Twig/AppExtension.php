<?php
namespace AppBundle\Twig;

// http://symfony.com/doc/current/templating/twig_extension.html
//https://twig.symfony.com/doc/2.x/advanced.html#id2
//https://stackoverflow.com/questions/9633723/symfony2-twig-how-to-tell-the-custom-twig-tag-to-not-escape-the-output

/**
 * Class AppExtension
 *
 * @package AppBundle\Twig
 */
class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
           // new \Twig_SimpleFilter('label', array($this, 'labelFilter', ['is_safe' => ['html']])),
        );
    }
    public function getFunctions()
    {
        return array(
             'label' => new \Twig_Function_Method($this, 'labelFilter', ['is_safe' => ['html']]),
        );
    }
    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$'.$price;

        return $price;
    }

    public function labelFilter($value)
    {
        //{% if user.isActive %}Yes{% else %}No{% endif %}
        return '<small class="label ' . ($value ? 'label-success': 'label-danger') . '">' . ($value ? 'Активен': 'Неактивен') . '</small>';
    }
}