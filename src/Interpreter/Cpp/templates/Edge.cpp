#include <iostream>
#include "Edge.h"

using namespace std;

namespace Blocks
{
    Edge::Edge(Block *from_, Index *indexFrom_, Block *to_, Index *indexTo_)
        : from(from_), indexFrom(indexFrom_), to(to_), indexTo(indexTo_)
    {
        from->addEdge(this);
        to->addEdge(this);
    }

    Edge::~Edge()
    {
        delete indexFrom;
        delete indexTo;
    }

    Index *Edge::getIndex(Block *block)
    {
        if (block == from) {
            return indexFrom;
        }

        return indexTo;
    }
};
