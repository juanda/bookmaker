<?php
/**
 * User: juandalibaba
 * Date: 23/09/13
 * Time: 21:03
 */

namespace Jazzyweb\Loaders;


use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;

class YamlConfigLoader extends FileLoader
{
    public function load($resource, $type = null)
    {
        $configValues = Yaml::parse($resource);

        // ... handle the config values

        // maybe import some other resource:

        // $this->import('extra_users.yml');
    }

    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'yml' === pathinfo(
            $resource,
            PATHINFO_EXTENSION
        );
    }
}