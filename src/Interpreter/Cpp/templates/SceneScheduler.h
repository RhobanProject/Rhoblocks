#ifndef _BLOCKS_SCENE_SCHEDULER_H
#define _BLOCKS_SCENE_SCHEDULER_H

#include "Scene.h"

namespace Blocks
{
    class SceneScheduler
    {
        public:
            SceneScheduler(Scene *scene);
            ~SceneScheduler();

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
