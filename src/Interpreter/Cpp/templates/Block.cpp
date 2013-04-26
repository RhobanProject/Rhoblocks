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
        edges[edge->getIndex(this)->getName()].push_back(edge);
    }
};
