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
    
    Block *Edge::getDestination()
    {
        return to;
    }

    Block *Edge::getSource()
    {
        return from;
    }

    scalar Edge::getValue()
    {
        return from->getOutput(indexFrom->getIndex(), indexFrom->getSubIndex());
    }

    Index *Edge::getIndex(Block *block)
    {
        if (block == from) {
            return indexFrom;
        }

        return indexTo;
    }

    bool Edge::startsFrom(Block *block)
    {
        return (block == from);
    }

    void Edge::propagate()
    {
        if (indexTo->getName() == "input") {
            to->setInput(indexTo->getIndex(), indexTo->getSubIndex(), getValue());
        }

        if (indexTo->getName() == "param") {
            to->setParameter(indexTo->getIndex(), getValue());
        }
    }
};
