<?php 

namespace App\Controllers\Web;

abstract class BaseController
{
    protected $container;

    /**
     * Create a new container instance
     *
     * @param $container
     * @return void
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Dynamically access the properties
     *
     * @param string $property
     * @return mixed
     */

    public function __get($property)
    {
        if ($this->container->{$property}) {
            return $this->container->{$property};
        }
    }

    public function paginateArray($data, $page, $per_page)
    {

        $total = count($data);
        $pages = (int) ceil($total / $per_page);

        $start = ($page - 1) * ($per_page);
        $offset = $per_page;

        $outArray = array_slice($data, $start, $offset);

        $result = [
            'data'        => $outArray,
            'pagination'  =>[
                'total_data'=> $total,
                'perpage'   => $per_page,
                'current'   => $page,
                'total_page'=> $pages,
                'first_page'=> 1,
            ]
        ];

        return $result;
    }

}