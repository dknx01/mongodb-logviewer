<?php
/**
 * Created by JetBrains PhpStorm.
 * User: erik
 * Date: 26.06.13
 * Time: 21:22
 * To change this template use File | Settings | File Templates.
 */

namespace Mvc\Db\MongoDb;


class Model
{
    /**
     * @var string
     */
    protected $objectId;

    /**
     * @var null|\stdClass
     */
    protected $nonMapped = null;

    public function __construct()
    {
        $this->nonMapped = new \stdClass();
    }
}