#include <iostream>
#include "<?php echo $name; ?>Block.h"

using namespace std;

namespace Blocks
{
    <?php echo $name; ?>Block::<?php echo $name; ?>Block(string jsonData)
    {
        Json::Value block;
        Json::Reader reader;

        if (!reader.parse(jsonData, block)) {
            throw string("Unable to parse the block <?php echo $name; ?>");
        }

        load(block);
    }
            
    <?php echo $name; ?>Block::<?php echo $name; ?>Block(const Json::Value &block)
    {
        load(block);
    }

    void <?php echo $name; ?>Block::load(const Json::Value &block)
    {
        cout << "Loading block data for block <?php echo $name; ?>" << endl;
    }
};
