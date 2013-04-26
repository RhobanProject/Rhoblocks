#ifndef _BLOCKS_EDGE_H
#define _BLOCKS_EDGE_H

namespace Blocks
{
    class Edge;
};

#include <iostream>
#include "Index.h"
#include "Block.h"

using namespace std;

namespace Blocks
{
    class Edge
    {
        public:
            Edge(Block *from, Index *indexFrom, Block *to, Index *indexTo);
            ~Edge();

            Index *getIndex(Block *concerned);

        protected:
            Block *from;
            Index *indexFrom;

            Block *to;
            Index *indexTo;
    };
};

#endif
