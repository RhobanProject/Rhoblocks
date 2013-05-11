#ifndef _BLOCKS_SCHEDULER_H
#define _BLOCKS_SCHEDULER_H

#include "Scene.h"

namespace Blocks
{
    class Scheduler
    {
        public:
            Scheduler(Scene *scene);
            ~Scheduler();

            void initialize();
            void topologicalSort();
            void run();
            void tick();

        protected:
            Scene *scene;
            vector<int> topological;
            set<Block *> visitedBlocks;
    
            void visit(Block *block);
    };
};

#endif
