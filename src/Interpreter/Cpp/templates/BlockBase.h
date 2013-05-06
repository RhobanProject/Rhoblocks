#ifndef _BLOCKS_<?php echo $upname; ?>_BASE_H
#define _BLOCKS_<?php echo $upname; ?>_BASE_H

#include <jsoncpp/json/json.h>
#include <iostream>
#include <blocks/Block.h>

using namespace std;

namespace Blocks
{
    class <?php echo $name; ?>BlockBase : public Block
    {
        public:
            <?php echo $name; ?>BlockBase();
            <?php echo $name; ?>BlockBase(string jsonData);
            <?php echo $name; ?>BlockBase(const Json::Value &block);
            virtual ~<?php echo $name; ?>BlockBase();

            string getName();
            
            virtual scalar getOutput(int index, int subIndex);
            virtual void setInput(int index, int subIndex, scalar value);
            virtual void setParameter(int index, scalar value);

            // Parameters, inputs and outputs
            <?php $sections = array('inputs', 'outputs', 'parameters');
                foreach ($sections as $section) {
                    foreach ($meta[$section] as $entry) {
                        // Variadic parameter, adding all the sub entries types
                        if (isset($entry['type']) && is_array($entry['type'])) {
                            foreach ($entry['type'] as $subEntry) { 
                                ?>
                                map<int, <?php echo $entry['cType']; ?> > <?php echo $entry['fieldName']; ?>_<?php echo $subEntry['fieldName']; ?>;
                                <?php
                            }
                        } else {
            ?>
            <?php echo $entry['cType']; ?> <?php echo $entry['fieldName']; ?>;
            <?php 
                        }
                    }
                }
            ?>
            
        protected:
            void load(const Json::Value &block);
    };
};

#endif
