#include <cstdio>
#include <iostream>
#include "Scene.h"

using namespace std;

namespace Blocks
{
    Scene::Scene() 
        : frequency(50), name("Unnamed")
    {
    }

    Scene::Scene(string name_)
        : frequency(50), name(name_)
    {
    }

    Scene::~Scene()
    {
        map<int, Block*>::iterator it;

        for (it=blocks.begin(); it!=blocks.end(); it++) {
            delete (*it).second;
        }

        vector<Edge *>::iterator eit;

        for (eit=edges.begin(); eit!=edges.end(); eit++) {
            delete *eit;
        }
    }

    void Scene::initialize()
    {
        map<int, Block*>::iterator it;

        for (it=blocks.begin(); it!=blocks.end(); it++) {
            (*it).second->initialize(NULL);
        }
    }

    bool Scene::hasBlock(int id)
    {
        return (blocks.find(id) != blocks.end());
    }

    void Scene::addBlock(Block *block)
    {
        if (block == NULL) {
            throw string("Trying to add a NULL block to the scene");
        }

        int id = block->getId();
        Block *current = getBlock(id);
            
        block->setScene(this);
        block->initialize(current);

        if (current != NULL) {
            delete current;
        }

        blocks[id] = block;
    }

    void Scene::addEdge(Edge *edge)
    {
        edges.push_back(edge);
    }
    
    vector<Block *> Scene::allBlocks()
    {
        vector<Block *> blocksVect;
        map<int, Block *>::iterator it;
        
        for (it=blocks.begin(); it!=blocks.end(); it++) {
            blocksVect.push_back((*it).second);
        }

        return blocksVect;
    }
            
    Block *Scene::getBlock(int id)
    {
        if (hasBlock(id)) {
            return blocks[id];
        }

        return NULL;
    }

    int Scene::getFrequency()
    {
        return frequency;
    }

    scalar Scene::getPeriod()
    {
        return 1.0/frequency;
    }

    string Scene::getName()
    {
        return name;
    }

    void Scene::setName(string name_)
    {
        name = name_;
    }
};
