#include <iostream>
#include <fstream>
#include "blocks/Loader.h"
#include "blocks/Scene.h"
#include "blocks/Scheduler.h"

using namespace std;

int main()
{
    cout << "Demo program, trying to load scene.json ..." << endl;
    try {
        ifstream sceneFile("scene.json");
        string jsonData;
        std::string content((std::istreambuf_iterator<char>(sceneFile) ),
                (std::istreambuf_iterator<char>()));

        Blocks::Loader loader;
        Blocks::Scene *scene = loader.loadScene(content);
        Blocks::Scheduler scheduler(scene);

        scheduler.run();
    } catch (string error) {
        cout << "Error: " << error << endl;
    }
}
