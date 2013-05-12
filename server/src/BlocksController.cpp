#include <iostream>
#include "BlocksController.h"

using namespace std;
        
Response *BlocksController::process(Request &request)
{
    JsonResponse *response = NULL;

    // The blocks control is under "/api" prefix
    setPrefix("/api");

    return response;
}
