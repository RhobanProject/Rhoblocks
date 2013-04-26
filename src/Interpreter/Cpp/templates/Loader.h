#ifndef _BLOCKS_LOADER_H
#define _BLOCKS_LOADER_H

#include <iostream>
#include "Scene.h"

using namespace std;

namespace Blocks
{
    class Loader
    {
        public:
            Scene *loadScene(string json);
    };
};

#endif
