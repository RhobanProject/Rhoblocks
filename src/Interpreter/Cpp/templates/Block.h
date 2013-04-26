#ifndef _BLOCKS_BLOCK_H
#define _BLOCKS_BLOCK_H

#include <iostream>

using namespace std;

namespace Blocks
{
    class Block
    {
        public:
            Block();

            virtual void initialize(Block *old);
    };
};

#endif
