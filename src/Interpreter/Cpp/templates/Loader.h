#ifndef _BLOCKS_LOADER_H
#define _BLOCKS_LOADER_H

#include <jsoncpp/json/json.h>
#include <iostream>
#include <fstream>
#include "Scene.h"
#include "Block.h"
#include "Edge.h"
#include "Index.h"

using namespace std;

namespace Blocks
{
    class Loader
    {
        public:
            Scene *loadScene(string json);
            Scene *loadSceneFromFile(string filename);

            Block *createBlock(const Json::Value &block);
            
            Block *findEdgeBlock(Scene *scene, int id);
            Edge *createEdge(const Json::Value &edge, Scene *scene);
    };
};

#endif
