// You need to install JsonCpp to get this working
#include <jsoncpp/json/json.h>
#include <sstream>
#include "Loader.h"
<?php foreach ($blocks as $block) { ?>
#include "<?php echo $block->getFileName(); ?>.h"
<?php } ?>

using namespace std;

namespace Blocks
{
    Scene *Loader::loadSceneFromFile(string fileName)
    {
        ifstream sceneFile(fileName.c_str());
        string jsonData;
        std::string content((std::istreambuf_iterator<char>(sceneFile) ),
                (std::istreambuf_iterator<char>()));

        return loadScene(content);
    }

    Scene *Loader::loadScene(string json)
    {
        Json::Value root;
        Json::Reader reader;
        
        if (!reader.parse(json, root)) {
            throw string("Could not parse the given scene: "+reader.getFormattedErrorMessages());
        }

        if (root.isArray()) {
            root = root[1];
        }

        if (root["blocks"].isNull() || root["edges"].isNull()) {
            throw string("The scene must contain blocks and edges nodes");
        }

        Scene *scene = new Scene;

        try {
            // Handling all the blocks
            const Json::Value blocks = root["blocks"];
            for (int i=0; i<blocks.size(); i++) {
                Block *newBlock = createBlock(blocks[i]);
                scene->addBlock(newBlock);
            }

            // Handling all the edges
            const Json::Value edges = root["edges"];
            for (int i=0; i<edges.size(); i++) {
                Edge *newEdge = createEdge(edges[i], scene);
                scene->addEdge(newEdge);
            }
            
        } catch (string error) {
            delete scene;
            throw error;
        }

        return scene;
    }

    Block *Loader::createBlock(const Json::Value &block)
    {
        Block *newBlock = NULL;

        if (block["type"].isNull() || !block["type"].isString()) {
            throw string("A block doesn't have any type");
        }
        
        string type = block["type"].asString();
        
        if (block["module"].isNull() || !block["module"].isString()) {
            ostringstream error;
            error << "A block of type " << type << " doesn't have module";
            throw error.str();
        }

        string module = block["module"].asString();

        <?php foreach ($blocks as $block) { ?>
            // <?php echo $block->getName(); ?>
            
            if (newBlock == NULL && module == "<?php echo $block->getModule(); ?>" && type == "<?php echo $block->getName(); ?>") {
                newBlock = new <?php echo $block->getName(); ?>Block();
                newBlock->load(block);
            }
        <?php } ?>

        if (newBlock == NULL) {
            throw string("Unknown block type " + module + "." + type);
        }

        return newBlock;
    }

    Block *Loader::findEdgeBlock(Scene *scene, int id)
    {
        Block *block = scene->getBlock(id);

        if (block == NULL) {
            ostringstream oss;
            oss << "Invalid edge, unable to find the block " << id;
            throw oss.str();
        }

        return block;
    }

    Edge *Loader::createEdge(const Json::Value &edge, Scene *scene)
    {
        if (!edge["block1"].isInt() || !edge["block2"].isInt()) {
            throw string("Invalid edge, block1 or block2 is not an integer");
        }

        if (!edge["io1"].isString() || !edge["io2"].isString()) {
            throw string("Invalid edge, input/output should be strings identifiers");
        }

        Block *blockFrom = findEdgeBlock(scene, edge["block1"].asInt());
        Block *blockTo = findEdgeBlock(scene, edge["block2"].asInt());

        Index *indexFrom = Index::fromString(edge["io1"].asString());
        Index *indexTo = Index::fromString(edge["io2"].asString());

        return new Edge(blockFrom, indexFrom, blockTo, indexTo);
    }
};
