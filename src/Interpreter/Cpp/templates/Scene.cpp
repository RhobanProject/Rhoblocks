#include <cstdio>
#include <iostream>
#include "Scene.h"

using namespace std;

namespace Blocks
{
    Scene::Scene()
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
            
        block->initialize(current);

        if (current != NULL) {
            delete current;
        }

        blocks[id] = block;
        block->setScene(this);
    }

    void Scene::addEdge(Edge *edge)
    {
        edges.push_back(edge);
    }
            
    Block *Scene::getBlock(int id)
    {
        if (hasBlock(id)) {
            return blocks[id];
        }

        return NULL;
    }
};
