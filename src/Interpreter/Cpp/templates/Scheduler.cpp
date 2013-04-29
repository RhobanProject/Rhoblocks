#include <set>
#include <algorithm>
#include <iostream>
#include "Scheduler.h"

using namespace std;

namespace Blocks
{
    Scheduler::Scheduler(Scene *scene_)
    {
        scene = scene_;
    }

    Scheduler::~Scheduler()
    {
        if (scene != NULL) {
            delete scene;
        }
    }

    void Scheduler::visit(Block *block)
    {
        if (visitedBlocks.find(block) == visitedBlocks.end()) {
            visitedBlocks.insert(block);
            set<Block *> successors = block->allSuccessors();
            set<Block *>::iterator it;

            for (it=successors.begin(); it!=successors.end(); it++) {
                visit(*it);
            }

            topological.push_back(block->getId());
        }
    }

    void Scheduler::topologicalSort()
    {
        topological.clear();
        visitedBlocks.clear();
        vector<Block *> allBlocks = scene->allBlocks();
        vector<Block *>::iterator it;

        for (it=allBlocks.begin(); it!=allBlocks.end(); it++) {
            visit(*it);
        }

        reverse(topological.begin(), topological.end());

        vector<int>::iterator tit;
    }

    void Scheduler::tick()
    {
        for (int i=0; i<topological.size(); i++) {
            Block *block = scene->getBlock(topological[i]);
            block->tick();
            block->propagate();
        }
    }

    void Scheduler::run()
    {
        topologicalSort();

        while (1) {
            tick();
            usleep(1000000/scene->getFrequency());
        }
    }
};