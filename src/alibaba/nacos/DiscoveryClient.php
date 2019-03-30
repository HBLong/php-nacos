<?php


namespace alibaba\nacos;


use alibaba\nacos\model\Beat;
use alibaba\nacos\model\Instance;
use alibaba\nacos\model\InstanceList;
use alibaba\nacos\request\discovery\BeatInstanceDiscovery;
use alibaba\nacos\request\discovery\DeleteInstanceDiscovery;
use alibaba\nacos\request\discovery\GetInstanceDiscovery;
use alibaba\nacos\request\discovery\ListInstanceDiscovery;
use alibaba\nacos\request\discovery\RegisterInstanceDiscovery;
use alibaba\nacos\request\discovery\UpdateInstanceDiscovery;

/**
 * Class DiscoveryClient
 * @author suxiaolin
 * @package alibaba\nacos
 */
class DiscoveryClient
{
    /**
     * @param $serviceName
     * @param $ip
     * @param $port
     * @param string $weight
     * @param string $namespaceId
     * @param bool $enable
     * @param bool $healthy
     * @param string $metadata
     * @param string $clusterName
     * @return bool
     * @throws \ReflectionException
     * @throws exception\RequestUriRequiredException
     * @throws exception\RequestVerbRequiredException
     * @throws exception\ResponseCodeErrorException
     */
    public static function register($serviceName, $ip, $port, $weight = "", $namespaceId = "", $enable = true, $healthy = true, $clusterName = "", $metadata = "{}")
    {
        $registerInstanceDiscovery = new RegisterInstanceDiscovery();
        $registerInstanceDiscovery->setServiceName($serviceName);
        $registerInstanceDiscovery->setIp($ip);
        $registerInstanceDiscovery->setPort($port);
        $registerInstanceDiscovery->setNamespaceId($namespaceId);
        $registerInstanceDiscovery->setWeight($weight);
        $registerInstanceDiscovery->setEnable($enable);
        $registerInstanceDiscovery->setHealthy($healthy);
        $registerInstanceDiscovery->setMetadata($metadata);
        $registerInstanceDiscovery->setClusterName($clusterName);

        $response = $registerInstanceDiscovery->doRequest();
        return $response->getBody()->getContents() == "ok";
    }

    /**
     * @param $serviceName
     * @param $ip
     * @param $port
     * @param string $namespaceId
     * @param string $clusterName
     * @return bool
     * @throws \ReflectionException
     * @throws exception\RequestUriRequiredException
     * @throws exception\RequestVerbRequiredException
     * @throws exception\ResponseCodeErrorException
     */
    public static function delete($serviceName, $ip, $port, $namespaceId = "", $clusterName = "")
    {
        $deleteInstanceDiscovery = new DeleteInstanceDiscovery();
        $deleteInstanceDiscovery->setServiceName($serviceName);
        $deleteInstanceDiscovery->setIp($ip);
        $deleteInstanceDiscovery->setPort($port);
        $deleteInstanceDiscovery->setNamespaceId($namespaceId);
        $deleteInstanceDiscovery->setClusterName($clusterName);

        $response = $deleteInstanceDiscovery->doRequest();
        return $response->getBody()->getContents() == "ok";
    }

    /**
     * @param $serviceName
     * @param $ip
     * @param $port
     * @param string $weight
     * @param string $namespaceId
     * @param string $clusterName
     * @param string $metadata
     * @return bool
     * @throws \ReflectionException
     * @throws exception\RequestUriRequiredException
     * @throws exception\RequestVerbRequiredException
     * @throws exception\ResponseCodeErrorException
     */
    public static function update($serviceName, $ip, $port, $weight = "", $namespaceId = "", $clusterName = "", $metadata = "{}")
    {
        $updateInstanceDiscovery = new UpdateInstanceDiscovery();
        $updateInstanceDiscovery->setServiceName($serviceName);
        $updateInstanceDiscovery->setIp($ip);
        $updateInstanceDiscovery->setPort($port);
        $updateInstanceDiscovery->setNamespaceId($namespaceId);
        $updateInstanceDiscovery->setWeight($weight);
        $updateInstanceDiscovery->setMetadata($metadata);
        $updateInstanceDiscovery->setClusterName($clusterName);

        $response = $updateInstanceDiscovery->doRequest();
        $content = $response->getBody()->getContents();
        return $content == "ok";
    }

    /**
     * @param $serviceName
     * @param bool $healthyOnly
     * @param string $namespaceId
     * @param string $clusters
     * @return model\InstanceList
     * @throws \ReflectionException
     * @throws exception\RequestUriRequiredException
     * @throws exception\RequestVerbRequiredException
     * @throws exception\ResponseCodeErrorException
     */
    public static function listInstances($serviceName, $healthyOnly = false, $namespaceId = "", $clusters = "")
    {
        $listInstanceDiscovery = new ListInstanceDiscovery();
        $listInstanceDiscovery->setServiceName($serviceName);
        $listInstanceDiscovery->setNamespaceId($namespaceId);
        $listInstanceDiscovery->setClusters($clusters);
        $listInstanceDiscovery->setHealthyOnly($healthyOnly);

        $response = $listInstanceDiscovery->doRequest();
        $content = $response->getBody()->getContents();

        return InstanceList::decode($content);
    }

    /**
     * @param $serviceName
     * @param $ip
     * @param $port
     * @param bool $healthyOnly
     * @param string $weight
     * @param string $namespaceId
     * @param string $clusters
     * @return model\Instance
     * @throws \ReflectionException
     * @throws exception\RequestUriRequiredException
     * @throws exception\RequestVerbRequiredException
     * @throws exception\ResponseCodeErrorException
     */
    public static function get($serviceName, $ip, $port, $healthyOnly = false, $weight = "", $namespaceId = "", $clusters = "")
    {
        $getInstanceDiscovery = new GetInstanceDiscovery();
        $getInstanceDiscovery->setServiceName($serviceName);
        $getInstanceDiscovery->setIp($ip);
        $getInstanceDiscovery->setPort($port);
        $getInstanceDiscovery->setNamespaceId($namespaceId);
        $getInstanceDiscovery->setCluster($clusters);
        $getInstanceDiscovery->setHealthyOnly($healthyOnly);

        $response = $getInstanceDiscovery->doRequest();
        $content = $response->getBody()->getContents();

        return Instance::decode($content);
    }

    /**
     * @param $serviceName
     * @param $beat
     * @return model\Beat
     * @throws \ReflectionException
     * @throws exception\RequestUriRequiredException
     * @throws exception\RequestVerbRequiredException
     * @throws exception\ResponseCodeErrorException
     */
    public static function beat($serviceName, $beat)
    {
        $beatInstanceDiscovery = new BeatInstanceDiscovery();
        $beatInstanceDiscovery->setServiceName($serviceName);
        $beatInstanceDiscovery->setBeat($beat);

        $response = $beatInstanceDiscovery->doRequest();
        $content = $response->getBody()->getContents();
        return Beat::decode($content);
    }
}