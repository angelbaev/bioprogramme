<?php
namespace AppBundle\Twig;

// http://symfony.com/doc/current/templating/twig_extension.html
//https://twig.symfony.com/doc/2.x/advanced.html#id2
//https://stackoverflow.com/questions/9633723/symfony2-twig-how-to-tell-the-custom-twig-tag-to-not-escape-the-output
use AppBundle\Helper\ImageHelper;
use BioprogrammeAccountBundle\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AppExtension
 *
 * @package AppBundle\Twig
 */
class AppExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    public function __construct(ContainerInterface $containerInterface, EntityManagerInterface $entityManager)
    {
        $this->container = $containerInterface;
        $this->em = $entityManager;
    }

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
            'image_resize' => new \Twig_SimpleFunction('image_resize', [$this, 'imageResize'], ['is_safe' => ['html']]),
            'array_chunk' => new \Twig_SimpleFunction('array_chunk', [$this, 'arrayChunk']),
            'get_attribute_id' => new \Twig_SimpleFunction('get_attribute_id', [$this, 'findIdFromAttribute']),
            'prity_roles' => new \Twig_SimpleFunction('prity_roles', [$this, 'prityRoles'], ['is_safe' => ['html']]),
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
    public function labelFilter($value, $labels = ['Неактивен', 'Активен'])
    {
        //{% if user.isActive %}Yes{% else %}No{% endif %}
        return '<small class="label ' . ($value ? 'label-success': 'label-danger') . '">' . ($value ? $labels[1]: $labels[0]) . '</small>';
    }

    /**
     * Resize image
     *
     * @param string $file
     * @param int $width
     * @param int $height
     *
     * @return string
     */
    public function imageResize($file, $width, $height)
    {
        $image = ImageHelper::resize($this->container, $file, $width, $height);
        if ($image) {
            return $image;
        }

        return ImageHelper::resize($this->container, 'img/no_image.jpg', $width, $height);
    }

    /**
     * Split an array into chunks
     *
     * @param array      $array
     * @param            $size
     * @param bool|FALSE $preserveKeys
     *
     * @return array
     */
    public function arrayChunk($array , $size, $preserveKeys = false)
    {
        return array_chunk((array)$array, $size, $preserveKeys);
    }

    /**
     * @param $str
     *
     * @return string
     */
    public function findIdFromAttribute($str)
    {
        preg_match_all('/\\"(.*?)\\"/', $str, $matches);

        return (isset($matches[1][0]) ? $matches[1][0] . '_thumb' : 'thumb');
    }

    /**
     * Show prity roles
     *
     * @param        $codes
     * @param string $separator
     *
     * @return string
     */
    public function prityRoles($codes, $separator = ',')
    {
        $roleNames = [];
        $repository = $this->em->getRepository(Role::class);
        $roles = $repository->findBy(['code' => $codes, 'isActive' => 1]);

        foreach($roles as $role) {
            $roleNames[] = $role->getName();
        }

        $roleNames[] = 'User';
        $roleNames = array_unique($roleNames);

        return implode($separator, $roleNames);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'app';
    }
}