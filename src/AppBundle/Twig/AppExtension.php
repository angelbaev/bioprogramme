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
    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
        );
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'label' => new \Twig_SimpleFunction('label', [$this, 'labelFilter'], ['is_safe' => ['html']]),
        );
    }

    /**
     * @param        $number
     * @param int    $decimals
     * @param string $decPoint
     * @param string $thousandsSep
     *
     * @return string
     */
    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$'.$price;

        return $price;
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function labelFilter($value)
    {
        //{% if user.isActive %}Yes{% else %}No{% endif %}
        return '<small class="label ' . ($value ? 'label-success': 'label-danger') . '">' . ($value ? 'Активен': 'Неактивен') . '</small>';
    }
}