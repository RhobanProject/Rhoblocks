#include <iostream>
#include "BlocksController.h"

using namespace std;
using namespace Blocks;
        
BlocksController::BlocksController(Scheduler *scheduler_)
    : JsonController(100), scheduler(scheduler_)
{
}
 
void BlocksController::getScenes(Request &request, JsonResponse &response)
{
    vector<string> scenes = scheduler->getScenes();
    vector<string>::iterator it;

    response["scenes"] = Json::Value(Json::arrayValue);
    int i = 0;
    for (it=scenes.begin(); it!=scenes.end(); it++) {
        response["scenes"][i++] = *it;
    }
}
        
void BlocksController::setup()
{
    // The blocks control is under "/api" prefix
    setPrefix("/api");

    // Get the loaded scenes
    addRouteResponse("GET", "/getScenes", BlocksController, getScenes, JsonResponse);
}
