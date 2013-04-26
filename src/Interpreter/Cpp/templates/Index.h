#ifndef _BLOCKS_INDEX_H
#define _BLOCKS_INDEX_H

#include <iostream>

using namespace std;

namespace Blocks
{
    class Index
    {
        public:
            Index(string name, int index, int subIndex = -1);

            static Index *fromString(string io);

            string getName();
            string getFullName();
            int getIndex();
            int getSubIndex();

        protected:
            string name;
            int index;
            int subIndex;
    };
};

#endif
