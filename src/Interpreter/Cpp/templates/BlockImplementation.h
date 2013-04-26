#ifndef _BLOCKS_<?php echo $upname; ?>_IMPL_H
#define _BLOCKS_<?php echo $upname; ?>_IMPL_H

#include <jsoncpp/json/json.h>
#include <iostream>
#include "Block.h"

using namespace std;

namespace Blocks
{
    class <?php echo $name; ?>Block : public Block
    {
        public:
            <?php echo $name; ?>Block(string jsonData);
            <?php echo $name; ?>Block(const Json::Value &block);

            void addEdge(Edge *edge);
            void initialize(Block *older);
            void tick();

            string getName();

            <?php echo $header; ?>

        protected:
            void load(const Json::Value &block);
    };
};

#endif
