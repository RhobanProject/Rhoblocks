#include <iostream>
#include <fstream>

#include <mongoose/Server.h>

#include <blocks/Loader.h>
#include <blocks/Scene.h>
#include <blocks/SceneScheduler.h>
#include <blocks/Scheduler.h>

#include "BlocksController.h"

using namespace std;
using namespace Mongoose;

int main()
{
    // Creating a scheduler with an empty scene
    Scene *emptyScene = new Scene("EmptyScene");
    Scheduler scheduler;
    scheduler.addScene(emptyScene);

    // Creating the server with the blocks controller
    Server server(8080, "www");
    BlocksController blocksController(&scheduler);
    server.registerController(&blocksController);

    cout << "Running the Rhoblocks Server..." << endl;
    server.start();

    while (1) {
        sleep(1);
    }
}
