#ifndef _BLOCKS_BLOCK_H
#define _BLOCKS_BLOCK_H

namespace Blocks {
    class Block;
};

#include <jsoncpp/json/json.h>
#include <iostream>
#include <map>
#include <vector>
#include "Scene.h"
#include "Edge.h"

using namespace std;

namespace Blocks
{
    class Block
    {
        public:
            Block();

            void setScene(Scene *scene);

            virtual void load(const Json::Value &block);
            virtual string getName()=0;
            virtual void initialize(Block *old);
            virtual void tick()=0;
            virtual void addEdge(Edge *edge);

            int getId();

        protected:
            Scene *scene;
            int id;
            map<string, vector<Edge *> > edges;
    };
};

#endif
