#ifndef _BLOCKS_JSON_UTIL_H
#define _BLOCKS_JSON_UTIL_H

#include <iostream>
#include <json/json.h>

using namespace std;

namespace Blocks
{
    class JsonUtil
    {
        public:
            static void readDouble(const Json::Value &node, double &value);
            static void readDouble(const Json::Value &node, string name, double &value);
            static void readDoubles(const Json::Value &node, string name, map<int, double> &array);
            static void readString(const Json::Value &node, string name, string &output);
    };
};

#endif
