<?php
/**
 * User: juandalibaba
 * Date: 23/09/13
 * Time: 21:07
 */

namespace Jazzyweb\Configuration;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class BookmakerConfiguration implements ConfigurationInterface{

    public function getConfigTreeBuilder(){
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('');

        $rootNode
            ->children()
                ->arrayNode('books')
                    ->prototype('array')
                    ->children()
                        ->scalarNode('source')->end()
                        ->scalarNode('output')->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }


}