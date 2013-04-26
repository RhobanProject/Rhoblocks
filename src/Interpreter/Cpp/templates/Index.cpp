#include <stdlib.h>
#include <vector>
#include <iostream>
#include <sstream>
#include "Index.h"

using namespace std;

static vector<string> &split(const string &s, char delim, vector<string> &elems) {
    stringstream ss(s);
    string item;
    while (getline(ss, item, delim)) {
        elems.push_back(item);
    }
    return elems;
}

namespace Blocks
{
    Index *Index::fromString(string io)
    {
        vector<string> parts;
        split(io, '_', parts);

        if (parts.size() < 2 || parts.size() > 3) {
            ostringstream oss;
            oss << "The edge index \"" << io << "\" is invalid";
            throw string(oss.str());
        }

        string name = parts[0];
        int index = atoi(parts[1].c_str());
        int subIndex = parts.size() == 3 ? atoi(parts[2].c_str()) : -1;

        return new Index(name, index, subIndex);
    }

    Index::Index(string name_, int index_, int subIndex_)
        : name(name_), index(index_), subIndex(subIndex_)
    {
    }
    
    string Index::getName()
    {
        return name;
    }

    string Index::getFullName()
    {
        ostringstream oss;
        oss << name << "_"  << index << "_" << subIndex;
        return oss.str();
    }

    int Index::getIndex()
    {
        return index;
    }

    int Index::getSubIndex()
    {
        return subIndex;
    }
}
