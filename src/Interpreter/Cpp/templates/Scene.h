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
            Scene(string name);
            ~Scene();

            void initialize();

            bool hasBlock(int id);
            void addBlock(Block *block);
            Block *getBlock(int id);
            vector<Block *> allBlocks();
            void addEdge(Edge *edge);

            int getFrequency();
            scalar getPeriod();

            string getName();
            void setName(string name);

        protected:
            string name;
            map<int, Block*> blocks;
            map<int, Edge*> edges;
            int frequency;
    };
};

#endif
