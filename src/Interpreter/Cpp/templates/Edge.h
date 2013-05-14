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
            Edge(int id, Block *from, Index *indexFrom, Block *to, Index *indexTo);
            ~Edge();

            void propagate();

            Block *getDestination();
            Block *getSource();

            int getId();

            Index *getIndex(Block *concerned);
            bool startsFrom(Block *block);

            scalar getValue();

        protected:
            int id;

            Block *from;
            Index *indexFrom;

            Block *to;
            Index *indexTo;
    };
};

#endif
