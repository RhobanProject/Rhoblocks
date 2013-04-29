#ifndef _BLOCKS_SCENE_H
#define _BLOCKS_SCENE_H

namespace Blocks {
    class Scene;
};

#include <vector>
#include <map>
#include "Edge.h"
#include "Block.h"

using namespace std;

namespace Blocks
{
    class Scene
    {
        public:
            Scene();
            ~Scene();

            bool hasBlock(int id);
            void addBlock(Block *block);
            Block *getBlock(int id);
            vector<Block *> allBlocks();
            void addEdge(Edge *edge);

            int getFrequency();
            scalar getPeriod();

        protected:
            map<int, Block*> blocks;
            vector<Edge *> edges;
            int frequency;
    };
};

#endif
