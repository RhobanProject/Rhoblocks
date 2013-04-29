#include <stdlib.h>
#include <sstream>
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
        Block::load(block);

        // Initializing inputs
        <?php foreach ($meta['inputs'] as $input) {
            if (isset($input['default']) && !isset($input['length'])) { ?>
        <?php echo $input['fieldName']; ?> = <?php echo $input['default']; ?>;
        <?php }
        }
        ?>

        // Reading parameters
        const Json::Value parameters = block["parameters"];
        <?php foreach ($meta['parameters'] as $entry) { ?>
        <?php if (isset($entry['type']) && is_array($entry['type'])) { ?>
        <?php foreach ($entry['type'] as $subEntry) { ?>
        <?php $vname = $entry['name'].'.'.$subEntry['name']; ?> 
        if (!parameters["<?php echo $vname; ?>"].isArray()) {
            throw string("The parameter <?php echo $vname; ?> should be an array");
        }
        Json::Value node = parameters["<?php echo $vname; ?>"];
        for (int i=0; i<node.size(); i++) {
            <?php echo $entry['fieldName']; ?>_<?php echo $subEntry['fieldName']; ?>[i] = node[i].asDouble();
        }

        <?php } ?>
        <?php } else { ?>
        <?php if ($entry['cType'] == 'string') { ?>
        if (!parameters["<?php echo $entry['name']; ?>"].isString()) {
            throw string("The parameter <?php echo $entry['name']; ?> should be a string");
        }
        <?php echo $entry['fieldName']; ?> = parameters["<?php echo $entry['name']; ?>"].asString();

        <?php } else { ?>
        if (parameters["<?php echo $entry['name']; ?>"].isNumeric()) {
            <?php echo $entry['fieldName']; ?> = parameters["<?php echo $entry['name']; ?>"].asDouble();
        } else if (parameters["<?php echo $entry['name']; ?>"].isString()) {
            <?php echo $entry['fieldName']; ?> = atoi(parameters["<?php echo $entry['name']; ?>"].asString().c_str());
        } else {
            throw string("The parameter <?php echo $entry['name']; ?> should be a float");
        }

        <?php } ?>
        <?php } ?>
        <?php } ?>

        // Initializing variadic I/O
        int size;
        <?php $sections = array('inputs', 'outputs');
        foreach ($sections as $section) {
            foreach ($meta[$section] as $entry) {
                if (isset($entry['length'])) { ?>
            <?php foreach ($meta['parameters'] as $param) { 
                if ($param['name'] == $entry['length'][0]) {
                    if ($entry['length'][1] == 'value') {
                    ?>
                    size = (int)<?php echo $param['fieldName']; ?>;
                    <?php
                    } 
                    if ($entry['length'][1] == 'length') {
                    ?>
                    size = 0;
                    <?php foreach ($param['type'] as $subEntry) { ?>
                    <?php $vname = $param['fieldName'].'_'.$subEntry['fieldName']; ?>
                    if (<?php echo $vname; ?>.size() > size) {
                        size = <?php echo $vname; ?>.size();
                    }
                    <? } ?>
                    <?php
                    }
        ?>
            for (int i=0; i<size; i++) {
                <?php echo $entry['fieldName']; ?>[i] = <?php echo isset($entry['default']) ? $entry['default'] : '0'; ?>;
            }
        <?php
                }
              }
            }
          }
        }
        ?>
    }

    string <?php echo $name; ?>Block::getName()
    {
        ostringstream oss;
        oss << "<?php echo $name; ?>#" << getId();
        return oss.str();
    }

    scalar <?php echo $name; ?>Block::getOutput(int index_, int subIndex_)
    {
        switch (index_) {
            <?php foreach ($meta['outputs'] as $index => $entry) { ?>
            case <?php echo $index; ?>:
                <?php if (isset($entry['length'])) { ?>
                return <?php echo $entry['fieldName']; ?>[subIndex_];
                <?php } else { ?>
                return <?php echo $entry['fieldName']; ?>;
                <?php } ?>
                break;
            <?php } ?>
        }

        return 0.0;
    }

    void <?php echo $name; ?>Block::setInput(int index_, int subIndex_, scalar value_)
    {
        switch (index_) {
            <?php foreach ($meta['inputs'] as $index => $entry) { ?>
            case <?php echo $index; ?>:
                <?php if (isset($entry['length'])) { ?>
                <?php echo $entry['fieldName']; ?>[subIndex_] = value_;
                <?php } else { ?>
                <?php echo $entry['fieldName']; ?> = value_;
                <?php } ?>
                break;
            <?php } ?>
        }
    }

    void <?php echo $name; ?>Block::setParameter(int index_, scalar value_)
    {
        switch (index_) {
            <?php foreach ($meta['parameters'] as $index => $entry) { ?>
            <?php if (!isset($entry['type']) || $entry['type'] == 'number' || $entry['type'] == 'integer') { ?>
            <?php if ($entry['card'][1]) { ?>
            case <?php echo $index; ?>:
                <?php echo $entry['fieldName']; ?> = value_;
                break;
            <?php } ?>
            <?php } ?>
            <?php } ?>
        }
    }

    <?php echo $code; ?>
};
