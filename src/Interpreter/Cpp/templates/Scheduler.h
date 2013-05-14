#ifndef _BLOCKS_SCHEDULER_H
#define _BLOCKS_SCHEDULER_H

#include <vector>
#include "SceneScheduler.h"

using namespace std;

namespace Blocks
{
    class Scheduler
    {
        public:
            Scheduler();
            ~Scheduler();

            /**
             * Adds a scene to the scheduler
             * 
             * @param Scene* the scene to add
             */
            void addScene(Scene *scene);

            /**
             * Does the scheduler have a scene named name?
             *
             * @param string the scene name
             *
             * @return bool true if the scene is already in the scheduler
             */
            bool hasScene(string name);

            /**
             * Get the loaded scenes
             *
             * @return a vector of loaded scene names
             */
            vector<string> getScenes();

            /**
             * Deletes all the scenes
             */
            void clear();

        protected:
            map<string, SceneScheduler*> scenes;
    };
};

#endif
