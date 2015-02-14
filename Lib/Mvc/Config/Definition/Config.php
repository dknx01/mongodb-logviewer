<?php
/**
 * claas to define some configuration entry and how to get a value from the configuration
 *
 * PHP version >=5.3
 *
 * @package Mvc\Config\Definition
 * @author  dknx01 <e.witthauer@gmail.com>
 */

namespace Mvc\Config\Definition;
use \SimpleXMLElement;

class Config extends SimpleXMLElement
{
    /**
     * check if the configuration has an database entry
     *
     * @return boolean
     */
    public function hasDatabase()
    {
        return !empty($this->database) ? true : false;
    }
    /**
     * the database host name
     *
     * @return string
     */
    public function getDatabaseHost()
    {
        return (string)$this->database->host;
    }
    /**
     * the database user
     *
     * @return string
     */
    public function getDatabaseUser()
    {
        return (string)$this->database->user;
    }
    /**
     * the database password
     *
     * @return string
     */
    public function getDatabasePassword()
    {
        return (string)$this->database->password;
    }
    /**
     * the database name
     *
     * @return string
     */
    public function getDatabaseName()
    {
        return (string)$this->database->name;
    }
    /**
     * should this connection be used (active)
     *
     * @return boolean
     */
    public function getDatabaseStatus()
    {
        if ($this->hasDatabase() == true && $this->database->active == 'true') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * the database port
     *
     * @return string
     */
    public function getDatabasePort()
    {
        return (string)$this->database->port;
    }
    /**
     * get all database params
     *
     * @return array
     */
    public function getDatabaseParams()
    {
        return $this->database->params;
    }
    /**
     * get the type of the database
     *
     * @return string
     */
    public function getDatabaseType()
    {
        $attributes = $this->database->attributes();
        $attributes = (array)$attributes;
        $attributes = $attributes['@attributes'];
        return $attributes['type'];
    }

    /**
     * get the path for a sqlite database
     *
     * @return string
     */
    public function getDatabasePath()
    {
        return (string)$this->database->path;
    }
    /**
     * get the value of a parameter
     *
     * @param string $name
     *
     * @return mixed the value
     */
    public function getParam($name)
    {
        $node = empty($this->$name) ? null : $this->$name;
        if (!is_null($node)) {
            $value = $this->checkChildren($node);
        } else {
            $value = $node;
        }
        return $value;
    }
    /**
     * check if a node has children and parse them
     *
     * @param SimpleXMLElement $node
     *
     * @return array|string
     */
    protected function checkChildren($node)
    {
        if (count($node->children()) > 0) {
            $value = array();
            if (count($node->attributes()) > 0) {
                $attributes = (array) $node->attributes();
                $attributes = $attributes['@attributes'];
                foreach ($attributes as $k => $v) {
                    $value['@attributes'][$k] = (string)$v;
                }
            }
            foreach ($node->children() as $k => $v) {
                if (count($v->children()) > 0) {
                    $value[$k] = $this->checkChildren($v);
                } else {
                    $value[$k] = (string)$v;
                }
            }
        } elseif (count($node->attributes()) > 0) {
            $attributes = (array) $node->attributes();
            $attributes = $attributes['@attributes'];
            foreach ($attributes as $k => $v) {
                $value['@attributes'][$k] = (string)$v;
            }
        } else {
            $value = (string)$node;
        }
        return $value;
    }
}
