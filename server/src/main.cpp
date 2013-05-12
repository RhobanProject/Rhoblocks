#include <iostream>
#include <fstream>

#include <mongoose/Server.h>

#include <blocks/Loader.h>
#include <blocks/Scene.h>
#include <blocks/SceneScheduler.h>

using namespace std;
using namespace Mongoose;

int main()
{
    Server server(8080, "www");

    cout << "Running the Rhoblocks Server..." << endl;
    server.start();

    while (1) {
        sleep(1);
    }
}
