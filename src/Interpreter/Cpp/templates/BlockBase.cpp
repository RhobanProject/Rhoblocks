#include <stdlib.h>
#include <sstream>
#include <iostream>
#include <blocks/JsonUtil.h>
#include "<?php echo $name; ?>Block.h"

using namespace std;

namespace Blocks
{
    <?php echo $name; ?>BlockBase::<?php echo $name; ?>BlockBase()
    {
    }
    
    <?php echo $name; ?>BlockBase::<?php echo $name; ?>BlockBase(string jsonData)
    {
        Json::Value block;
        Json::Reader reader;

        if (!reader.parse(jsonData, block)) {
            throw string("Unable to parse the block <?php echo $name; ?>");
        }

        load(block);
    }
            
    <?php echo $name; ?>BlockBase::<?php echo $name; ?>BlockBase(const Json::Value &block)
    {
        load(block);
    }

    void <?php echo $name; ?>BlockBase::load(const Json::Value &block)
    {
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
                <?php if (isset($entry['type']) && is_array($entry['type'])) {
                // Variadic parameter
                ?>
                <?php foreach ($entry['type'] as $subEntry) { ?>
                    <?php // The name of the parameter is Name.SubName
                          $vname = $entry['name'].'.'.$subEntry['name']; ?> 
                    JsonUtil::readDoubles(parameters, "<?php echo $vname; ?>", <?php echo $entry['fieldName']; ?>_<?php echo $subEntry['fieldName']; ?>);
                <?php } ?>
            <?php } else { ?>
                <?php
                    if ($entry['cType'] == 'string') {
                    // Reading string parameters from json
                    ?>
                    JsonUtil::readString(parameters, "<?php echo $entry['name']; ?>", <?php echo $entry['fieldName']; ?>);

                <?php } else {
                    // Int parameter, it can be a string so we'll use atoi() or a numeric value
                ?>
                    JsonUtil::readDouble(parameters, "<?php echo $entry['name']; ?>", <?php echo $entry['fieldName']; ?>);
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
                        // The size is the value of a parameter
                    ?>
                        size = (int)<?php echo $param['fieldName']; ?>;
                    <?php
                    } 
                    if ($entry['length'][1] == 'length') {
                        // The size is the length of a variadic parameter
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
                        // Initializing the values of the variadic I/O to 0
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

    string <?php echo $name; ?>BlockBase::getName()
    {
        ostringstream oss;
        oss << "<?php echo $module->getName(); ?>.<?php echo $name; ?>#" << getId();
        return oss.str();
    }

    scalar <?php echo $name; ?>BlockBase::getOutput(int index_, int subIndex_)
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

    void <?php echo $name; ?>BlockBase::setInput(int index_, int subIndex_, scalar value_)
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

    void <?php echo $name; ?>BlockBase::setParameter(int index_, scalar value_)
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
};
