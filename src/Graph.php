<?php

namespace Rhoban\Blocks;

use Rhoban\Blocks\GraphInterface;
use Rhoban\Blocks\FactoryInterface;
use Rhoban\Blocks\Exceptions\GenerateException;
use Rhoban\Blocks\Exceptions\LoadingException;

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
     * The graph edges
     */
    private $edges = array();

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
     * @param $factory : Rhoban\Blocks\FactoryInterface
     */
    public function __construct($json, FactoryInterface $factory)
    {
        $this->factory = $factory;
        $this->loadJSON($json);
        $this->checkCardinalities();
        $this->buildTopologicalSort();
    }

    /**
     * Gets a block by its id
     * @param $id the block id
     *
     * @return BlockInterface if the block is found, null else
     */
    public function getBlock($id)
    {
        $id = (int)$id;
        if (isset($this->blocks[$id])) {
            return $this->blocks[$id];
        }

        throw new \InvalidArgumentException('Unknown block Id '.$id);
    }

    /**
     * Simple indentation
     */
    public function indent($code)
    {
        $lines = explode("\n", $code);

        foreach ($lines as &$line) {
            $line = '    ' . trim($line);
        }

        return implode("\n", $lines);
    }

    /**
     * @inherit
     */
    public function generateInitCode()
    {
        $code = '';
        foreach ($this->topologicalSort as $id) {
            try {
                $code .= $this->getBlock($id)->generateInitCode();
            } catch (\Exception $e) {
                throw new GenerateException('Error while generating block '.$this->getBlock($id)->getBlockId().': '.$e->getMessage(), 0, $e);
            }
        }

        return $this->indent($code);
    }

    public function generateTransitionCode()
    {
        $code = '';
        foreach ($this->topologicalSort as $id) {
            try {
                $code .= "\n// Transition for ".$this->getBlock($id)->getBlockId()."\n";
                $code .= $this->getBlock($id)->generateTransitionCode();
            } catch (\Exception $e) {
                throw new GenerateException('Error while generating block '.$this->getBlock($id)->getBlockId().': '.$e->getMessage());
            }
        }

        return $this->indent($code);
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
            throw new LoadingException('Invalid JSON format');
        }

        //Blocks extracting and allocating
        foreach ($data['blocks'] as $block) {
            try {
                if (
                    !array_key_exists('id', $block) ||
                    !is_integer($block['id']) || 
                    !array_key_exists('type', $block) ||
                    !array_key_exists('parameters', $block) ||
                    !is_array($block['parameters'])
                ) {
                    throw new LoadingException(
                        'Invalid JSON blocks format');
                }
                $id = $block['id'];
                $type = $block['type'];
                $this->blocks[$id] = $this->factory->createBlock($type, $block);
            } catch (\Exception $e) {
                throw new LoadingException('Error while loading block '.$block['type'].'#'.$block['id'].': '.$e->getMessage(), 0, $e);
            }
        }
    
        //Edges extracting
        foreach ($data['edges'] as $edge) {
            if (!(isset($edge['block1']) && isset($edge['io1']) &&
                isset($edge['block2']) && isset($edge['io2']))) {
                    throw new \RuntimeException('Invalid JSON edges format');
                }

            $blockFrom = $this->getBlock($edge['block1']);
            $blockTo = $this->getBlock($edge['block2']);

            $edge = new Edge($blockFrom, $edge['io1'], $blockTo, $edge['io2']);
            $this->edges[] = $edge;
            $blockFrom->addEdge($edge);
            $blockTo->addEdge($edge);
        }
    }

    /**
     * Check block cardinality
     * Throw Exception if error
     */
    private function checkCardinalities()
    {
        foreach ($this->blocks as $block) {
            $block->checkCardinalities();
        }
    }

    /**
     * Check for graph loop and contruct the
     * topological sort
     * Throw Exception if error
     */
    private function buildTopologicalSort()
    {
        // Sorted blocks Id
        $sortedId = array();

        //Blocks Id without inputs
        $blocksId = array();

        // Graph edges
        $edges = array();
        $edgesReversed = array();

        // Insert all blocks
        foreach ($this->blocks as $block) {
            $blocksId[$block->getId()] = true;
            $edges[$block->getId()] = array();
            $edgesReversed[$block->getId()] = array();
        }

        //Rebuild edges list
        foreach ($this->edges as $edge) {
            if (!$edge->isLoopable()) {
                $edges[$edge->fromId()][$edge->toId()] = true;
                $edgesReversed[$edge->toId()][$edge->fromId()] = true;
            }
        }

        // Remove all block with incomming links
        foreach ($edgesReversed as $id => $links) {
            if (count($links) > 0) {
                unset($blocksId[$id]);
            }
        }

        // Topological sort algorithm
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
