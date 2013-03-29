<?php

namespace Rhoban\Blocks;

use Rhoban\Blocks\GraphInterface;
use Rhoban\Blocks\FactoryInterface;

/**
 * Graph
 */
class Graph implements GraphInterface
{
    /**
     * Block container
     */
    private $blocks = array();

    /**
     * Link container : src -> dst
     * Reversed links container : dst <- src
     */
    private $links = array();
    private $linksReversed = array();

    /**
     * Topological sort for block evaluation order
     */
    private $topologicalSort = array();

    /**
     * Compiler factory (Rhoban\Blocks\FactoryInterface)
     */
    private $factory;

    /**
     * Initialize the block graph
     * @param $json : json string representation
     * of the scene from blocks.js
     * @param $factory : FactoryInterface
     */
    public function __construct($json, FactoryInterface $factory)
    {
        $this->factory = $factory;
        $this->loadJSON($json);
        $this->checkCardinality();
        $this->buildTopologicalSort();
    }

    /**
     * @inherit
     */
    public function generateInitCode()
    {
        $code = '';
        foreach ($this->topologicalSort as $id) {
            $code .= $this->blocks[$id]->generateInitCode();
        }

        return $code;
    }
    public function generateTransitionCode()
    {
        $code = '';
        foreach ($this->topologicalSort as $id) {
            $code .= $this->blocks[$id]->generateTransitionCode(
                $this->linksReversed[$id]);
        }

        return $code;
    }

    /**
     * Parse json and build blocks and links data
     * @param $json : json string to parse
     */
    private function loadJSON($json)
    {
        //JSON serialization
        $data = json_decode($json, true);

        //Format check
        if (
            !$data || !is_array($data) || 
            !is_array($data['edges']) || !is_array($data['blocks'])
        ) {
            throw new \RuntimeException('Invalid JSON format');
        }

        //Blocks extracting and allocating
        foreach ($data['blocks'] as $block) {
            if (
                !array_key_exists('id', $block) ||
                !is_integer($block['id']) || 
                !array_key_exists('type', $block) ||
                !array_key_exists('parameters', $block) ||
                !is_array($block['parameters'])
            ) {
                throw new \RuntimeException(
                    'Invalid JSON blocks format');
            }
            $id = $block['id'];
            $type = $block['type'];
            $this->blocks[$id] = $this->factory->createBlock($type, $block);
        }

        //Links and LinksReversed structure initialization
        foreach ($this->blocks as $block) {
            $id = $block->getId();
            $meta = $block->getMeta();
            $this->links[$id] = array();
            $this->linksReversed[$id] = array();
            foreach ($meta['parameters'] as $index => $param) {
                $this->linksReversed[$id]['param_'.$index] = array();
            }
            foreach ($meta['inputs'] as $index => $input) {
                $this->linksReversed[$id]['input_'.$index] = array();
            }
            foreach ($meta['outputs'] as $index => $output) {
                $this->links[$id]['output_'.$index] = array();
            }
        }
    
        //Edges extracting
        foreach ($data['edges'] as $edge) {
            if (
                !array_key_exists('block1', $edge) ||
                !is_integer($edge['block1']) ||
                !array_key_exists('block2', $edge) || 
                !is_integer($edge['block2']) ||
                !array_key_exists('io1', $edge) || 
                !array_key_exists('io2', $edge)
            ) {
                throw new \RuntimeException(
                    'Invalid JSON edges format');
            }
            $srcId = $edge['block1'];
            $dstId = $edge['block2'];
            $srcIndex = $edge['io1'];
            $dstIndex = $edge['io2'];
            if (
                !strstr($srcIndex, 'output_') ||
                (!strstr($dstIndex, 'param_') && !strstr($dstIndex, 'input_'))
            ) {
                throw new \RuntimeException(
                    'Invalid JSON edges io format');
            }
            $this->links[$srcId][$srcIndex][] = array(
                'blockId' => $dstId,
                'index' => $dstIndex,
            );
            $this->linksReversed[$dstId][$dstIndex][] = array(
                'blockId' => $srcId,
                'index' => $srcIndex,
            );
        }
    }

    /**
     * Check block cardinality
     * Throw Exception if error
     */
    private function checkCardinality()
    {
        foreach ($this->blocks as $block) {
            $id = $block->getId();
            $meta = $block->getMeta();
            foreach ($meta['parameters'] as $index => $param) {
                $min = $block->getMinCardParam($index);
                $max = $block->getMaxCardParam($index);
                $this->checkCardMinMax($min, $max, $id, 'param_'.$index, true);
            }
            foreach ($meta['inputs'] as $index => $param) {
                $min = $block->getMinCardInput($index);
                $max = $block->getMaxCardInput($index);
                $this->checkCardMinMax($min, $max, $id, 'input_'.$index, true);
            }
            foreach ($meta['outputs'] as $index => $param) {
                $min = $block->getMinCardOutput($index);
                $max = $block->getMaxCardOutput($index);
                $this->checkCardMinMax($min, $max, $id, 'output_'.$index, false);
            }
        }
    }

    /**
     * Check a cardinality against min, max and graph links
     */
    private function checkCardMinMax($min, $max, $blockId, $index, $isReversed)
    {
        $count = 0;
        $array = array();

        if ($isReversed) {
            $array = $this->linksReversed;
        } else {
            $array = $this->links;
        }

        $count = count($array[$blockId][$index]);
        if ($count < $min || ($max && $count > $max)) {
            throw new \RuntimeException(
                'Invalid block cardinality parameters');
        }
    }

    /**
     * Check for graph loop and contruct the
     * topological sort
     * Throw Exception if error
     */
    private function buildTopologicalSort()
    {
        //Init structure
        //Sorted blocks Id
        $sortedId = array();
        //Blocks Id without inputs
        $blocksId = array();
        //Graph edges
        $edges = array();
        $edgesReversed = array();

        //Insert all blocks
        foreach ($this->blocks as $block) {
            $blocksId[$block->getId()] = true;
            $edges[$block->getId()] = array();
            $edgesReversed[$block->getId()] = array();
        }

        //Rebuild edges list
        foreach ($this->links as $id => $linksIndex) {
            foreach ($linksIndex as $links) {
                foreach ($links as $link) {
                    $edges[$id][$link['blockId']] = true;
                    $edgesReversed[$link['blockId']][$id] = true;
                }
            }
        }

        //Remove all block with incomming links
        foreach ($edgesReversed as $id => $links) {
            if (count($links) > 0) {
                unset($blocksId[$id]);
            }
        }

        //Topological sort algorithm
        while (count($blocksId) > 0) {
            reset($blocksId);
            $id = key($blocksId);
            $sortedId[] = $id;
            unset($blocksId[$id]);
            foreach ($edges[$id] as $dstId => $tmp) {
                unset($edges[$id][$dstId]);
                unset($edgesReversed[$dstId][$id]);
                if (count($edgesReversed[$dstId]) == 0) {
                    $blocksId[$dstId] = true;
                }
            }
        }

        foreach ($edges as $links) {
            if (count($links) > 0) {
                throw new \RuntimeException('Invalid cyclic graph');
            }
        }

        $this->topologicalSort = $sortedId;
    }
}
