<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

// https://symfony.com/doc/2.6/cookbook/form/create_custom_field_type.html
// https://symfony.com/doc/2.6/cookbook/form/form_customization.html#cookbook-form-customization-form-themes
/**
 * Class ImageType
 *
 * @package AppBundle\Form\Type
 */
class ImageType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
    }

    public function getParent()
    {
        return TextType::class;
    }

    public function getName()
    {
        return 'image';
    }
}