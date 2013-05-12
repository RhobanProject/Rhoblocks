#ifndef _BLOCKS_CONTROLLER_H
#define _BLOCKS_CONTROLLER_H

#include <mongoose/JsonController.h>
#include <mongoose/Request.h>

#include <blocks/Scheduler.h>

using namespace Mongoose;
using namespace Blocks;

class BlocksController : public JsonController
{
    public:
        BlocksController(Scheduler *scheduler);

        void getScenes(Request &request, JsonResponse &response);

        void setup();

    protected:
        Scheduler *scheduler;
};

#endif
