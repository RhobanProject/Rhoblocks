#include <iostream>
#include "Block.h"

using namespace std;

namespace Blocks
{
    Block::Block() : scene(NULL)
    {
    }

    void Block::initialize(Block *old)
    {
    }
    
    void Block::setScene(Scene *scene_)
    {
        scene = scene_;
    }

    int Block::getId()
    {
        return id;
    }
            
    set<Block *> Block::allSuccessors()
    {
        set<Block *> succ;
        vector<Edge *>::iterator it;

        for (it=successors.begin(); it!=successors.end(); it++) {
            Edge *edge = *it;
            succ.insert(edge->getDestination());
        }

        return succ;
    
    }

    void Block::load(const Json::Value &block)
    {
        if (block["id"].isNull() || !block["id"].isInt()) {
            throw string("Block <?php echo $name; ?> has no id");
        }
        id = block["id"].asInt();

        if (block["parameters"].isNull()) {
            throw string("Block " + getName() + " has no parameters");
        }
    }

    void Block::addEdge(Edge *edge)
    {
        if (edge->startsFrom(this)) {
            successors.push_back(edge);
        } else {
            predecessors.push_back(edge);
        }
    }

    void Block::propagate()
    {
        vector<Edge *>::iterator it;

        for (it=successors.begin(); it!=successors.end(); it++) {
            Edge *edge = (*it);
            edge->propagate();
        }
    }
};
