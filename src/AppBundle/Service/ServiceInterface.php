<?php
namespace AppBundle\Service;

/**
 * Interface ServiceInterface
 *
 * @package BioprogrammeAccountBundle\Service
 */
interface ServiceInterface
{
    /**
     * @param $entity
     *
     * @return mixed
     */
    public function save($entity);

    /**
     * @param $entity
     *
     * @return mixed
     */
    public function delete($entity);

    /**
     * @param array $items
     *
     * @return mixed
     */
    public function removeArrayCollection(array $items);

    /**
     * @return mixed
     */
    public function findAll();

    /**
     * @param array      $criteria
     * @param array|NULL $orderBy
     * @param null|int   $limit
     * @param null|int   $offset
     *
     * @return mixed
     */
    public function findBy(array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL);

    /**
     * @return mixed
     */
    public function getEntity();
}