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
    }

    bool Scene::hasBlock(int id)
    {
        return (blocks.find(id) != blocks.end());
    }

    void Scene::setBlock(int id, Block *block)
    {
        Block *current = getBlock(id);
            
        block->initialize(current);

        if (current != NULL) {
            delete current;
        }

        blocks[id] = block;
    }
            
    Block *Scene::getBlock(int id)
    {
        if (hasBlock(id)) {
            return blocks[id];
        }

        return NULL;
    }
};
