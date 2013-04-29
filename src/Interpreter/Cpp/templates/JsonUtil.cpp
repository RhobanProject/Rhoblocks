#include <stdlib.h>
#include <sstream>
#include <iostream>
#include "JsonUtil.h"

using namespace std;

namespace Blocks
{
    void JsonUtil::readDouble(const Json::Value &node, double &value)
    {
        if (node.isNumeric()) {
            value = node.asDouble();
        } else if (node.isString()) {
            value = atoi(node.asString().c_str());
        } else {
            throw string("Can't read such a double");
        }
    }

    void JsonUtil::readDouble(const Json::Value &node, string name, double &value)
    {
        try {
            JsonUtil::readDouble(node[name], value);
        } catch (string error) {
            ostringstream oss;
            oss << "The node " << name << " should be a float";
            throw oss.str();
        }
    }

    void JsonUtil::readDoubles(const Json::Value &node, string name, map<int, double> &array)
    {
        if (node[name].isArray()) {
            try {
                for (int i=0; i<node[name].size(); i++) {
                    double temp;
                    JsonUtil::readDouble(node[name][i], temp);
                    array[i] = temp;
                }
            } catch (string error) {
                ostringstream oss;
                oss << "The node " << name << " contains bad entry";
                throw oss.str();
            }
        } else {
            ostringstream oss;
            oss << "The node " << name << " should be an array";
            throw oss.str();
        }
    }

    void JsonUtil::readString(const Json::Value &node, string name, string &output)
    {
        if (node[name].isString()) {
            output = node[name].asString();
        } else {
            ostringstream oss;
            oss << "The node " << node << " should be a string";
            throw oss.str();
        }
    }
};
