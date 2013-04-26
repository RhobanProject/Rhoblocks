#ifndef _BLOCKS_SCENE_H
#define _BLOCKS_SCENE_H

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
            void setBlock(int id, Block *block);
            Block *getBlock(int id);

        protected:
            map<int, Block*> blocks;
    };
};

#endif
