#include <iostream>
#include "Scheduler.h"

using namespace std;

namespace Blocks
{
    Scheduler::Scheduler()
    {
    }

    Scheduler::~Scheduler()
    {
        clear();
    }

    void Scheduler::clear()
    {
        map<string, SceneScheduler*>::iterator it;

        for (it=scenes.begin(); it!=scenes.end(); it++) {
            delete (*it).second;
        }

        scenes.clear();
    }

    void Scheduler::addScene(Scene *scene)
    {
        string name = scene->getName();

        if (hasScene(name)) {
            delete scenes[name];
        }

        scenes[name] = new SceneScheduler(scene);
    }

    bool Scheduler::hasScene(string name)
    {
        return scenes.find(name) != scenes.end();
    }

    vector<string> Scheduler::getScenes()
    {
        vector<string> sceneNames;
        map<string, SceneScheduler*>::iterator it;

        for (it=scenes.begin(); it!=scenes.end(); it++) {
            sceneNames.push_back((*it).first);
        }

        return sceneNames;
    }
};
