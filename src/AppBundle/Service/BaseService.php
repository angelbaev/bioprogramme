<?php
namespace AppBundle\Service;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class BaseService
 *
 * @package BioprogrammeAccountBundle\Service
 */
class BaseService implements ServiceInterface
{
    /**
     * page limit
     */
    const LIMIT = 4;
    /**
     * @var EntityManager
     */
    protected $em;
    /**
     * @var
     */
    protected $entity;
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;
    /**
     * @var Container
     */
    protected $container;

    /**
     *
     * @param EntityManager $entityManager
     * @param Container     $container
     * @param               $entity
     */
    public function __construct(EntityManager $entityManager, Container $container, $entity)
    {
        $this->em = $entityManager;
        $this->container = $container;
        $this->entity = $entity;
        $this->repository = $this->em->getRepository($entity);
    }

    /**
     *
     * @param $entity
     */
    public function save($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * delete
     *
     * @param $entity
     */
    public function delete($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }

    /**
     * remove array collection
     *
     * @param array $authors
     */
    public function removeArrayCollection(array $items)
    {
        if (count($items)) {
            foreach ($items as $item) {
                $this->delete($item);
            }
        }
    }

    /**
     * find all
     *
     * @return type
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param array      $criteria
     * @param array|NULL $orderBy
     * @param null|int   $limit
     * @param null|int   $offset
     *
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL)
    {
        $criteria = array_filter($criteria);

        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param array      $criteria
     * @param array|NULL $orderBy
     * @param int        $page
     * @param int        $limit
     *
     * @return Paginator
     */
    public function search(array $criteria, array $orderBy = NULL, $page = 1, $limit = 20)
    {
        $criteria = array_diff(array_map('trim', $criteria), ['']);

        $query = $this->repository->createQueryBuilder('s');
        foreach($criteria as $fieldName => $value) {
            $operator = (is_numeric($value)? '=':'LIKE');
            $query->andWhere('s.' . $fieldName . ' ' . $operator . ' :' . $fieldName );
            $query->setParameter($fieldName, (is_numeric($value)? $value : '%' . $value . '%'));
        }

        if (!is_null($orderBy)) {
            list($sort, $order) = $orderBy;
            $query->orderBy('s.' . $sort, $order);
        }

        $query->getQuery();

        $paginator = new Paginator($query);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        return $paginator;
    }

    /**
     * @param array $criteria
     *
     * @return int
     */
    public function total(array $criteria = array())
    {
        $criteria = array_filter($criteria);
        $persister = $this->em->getUnitOfWork()->getEntityPersister($this->getEntity());

        return $persister->count($criteria);
    }
    /**
     * get entitiy
     *
     * @return type
     */
    public function getEntity()
    {
        return $this->entity;
    }
}