// You need to install JsonCpp to get this working
#include <jsoncpp/json/json.h>
#include "Loader.h"
<?php foreach ($blocks as $block) { ?>
#include "<?php echo $block['name']; ?>Block.h"
<?php } ?>

using namespace std;

namespace Blocks
{
    Scene *Loader::loadScene(string json)
    {
        Json::Value root;
        Json::Reader reader;
        
        if (!reader.parse(json, root)) {
            throw string("Could not parse the given scene: "+reader.getFormattedErrorMessages());
        }

        if (root["blocks"].isNull() || root["edges"].isNull()) {
            throw string("The scene must contain blocks and edges nodes");
        }

        // Handling all the blocks
        const Json::Value blocks = root["blocks"];
        for (int i=0; i<blocks.size(); i++) {
            bool typeFound = false;
            const Json::Value block = blocks[i];

            if (block["type"].isNull() || !block["type"].isString()) {
                throw string("A block doesn't have any type");
            }

            string type = block["type"].asString();

            if (block["id"].isNull() || !block["id"].isInt()) {
                throw string("Block " + type + " has no id");
            }

            int id = block["id"].asInt();

            <?php foreach ($blocks as $block) { ?>
                // <?php echo $block['name']; ?>
                
                if (!typeFound && type == "<?php echo $block['name']; ?>") {
                    typeFound = true;
                    Block *newBlock = new <?php echo $block['name']; ?>Block(block);
                }
            <?php } ?>

            if (typeFound = false) {
                throw string("Unknown block type " + type);
            }
        }
    }
};
