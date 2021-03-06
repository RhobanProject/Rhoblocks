#ifndef _BLOCKS_BLOCK_H
#define _BLOCKS_BLOCK_H

namespace Blocks {
    class Block;
};
typedef double scalar;
#define CARD_STAR 0xffff
 
#include <json/json.h>
#include <iostream>
#include <set>
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
            virtual ~Block();
            virtual void destroy();

            void setScene(Scene *scene);

            virtual void load(const Json::Value &block);
            virtual string getName()=0;
            virtual void initialize(Block *old);
            virtual void tick();
            virtual void addEdge(Edge *edge);
            void propagate();

            virtual scalar getOutput(int index, int subIndex)=0;
            virtual void setInput(int index, int subIndex, scalar value)=0;
            virtual void setParameter(int index, scalar value)=0;

            set<Block *> allSuccessors();

            int getId();

        protected:
            Scene *scene;
            int id;

            vector<Edge *> predecessors;
            vector<Edge *> successors;
    };
};

#endif
