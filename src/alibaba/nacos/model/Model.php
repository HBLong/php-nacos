<?php


namespace alibaba\nacos\model;


/**
 * Class Model
 * @author suxiaolin
 * @package alibaba\nacos\model
 */
abstract class Model
{
    protected $params = [];

    /**
     * @param $instanceJson
     * @return Model | Instance | InstanceList | Beat | Host
     */
    public static function decode($instanceJson)
    {
        $instance = new static();
        foreach (json_decode($instanceJson) as $propertyName => $propertyValue) {
            $instance->params[$propertyName] = $propertyValue;
            if (method_exists($instance, 'set' . ucfirst($propertyName))) {
                $instance->{'set' . ucfirst($propertyName)}($propertyValue);
            }
        }
        return $instance;
    }

    /**
     * @return false|string
     */
    public function encode()
    {
        return json_encode(get_object_vars($this));
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getParam(string $key, $default = null)
    {
        return method_exists($this, 'set' . ucfirst($key))
            ? $this->{'set' . ucfirst($key)}()
            : ($this->params[$key] ?? $default);
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}