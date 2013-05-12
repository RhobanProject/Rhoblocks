#include <iostream>
#include <fstream>
#include <blocks/Loader.h>
#include <blocks/Scene.h>
#include <blocks/SceneScheduler.h>

using namespace std;

int main()
{
    cout << "Demo program, trying to load scene.json ..." << endl;

    try {
        // Instanciate the loader
        Blocks::Loader loader;

        // Loads the scene
        Blocks::Scene *scene = loader.loadSceneFromFile("scene.json");

        // Schedule it
        Blocks::SceneScheduler scheduler(scene);
        scheduler.run();
    } catch (string error) {
        cout << "Error: " << error << endl;
    }
}
