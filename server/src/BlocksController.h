#ifndef _BLOCKS_CONTROLLER_H
#define _BLOCKS_CONTROLLER_H

#include <mongoose/JsonController.h>
#include <mongoose/Request.h>

using namespace Mongoose;

class BlocksController : public JsonController
{
    public:
        Response *process(Request &request);
};

#endif
