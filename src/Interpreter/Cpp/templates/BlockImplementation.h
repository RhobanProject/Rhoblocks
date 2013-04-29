#ifndef _BLOCKS_<?php echo $upname; ?>_IMPL_H
#define _BLOCKS_<?php echo $upname; ?>_IMPL_H

#include <jsoncpp/json/json.h>
#include <iostream>
#include <blocks/Block.h>

using namespace std;

namespace Blocks
{
    class <?php echo $name; ?>Block : public Block
    {
        public:
            <?php echo $name; ?>Block(string jsonData);
            <?php echo $name; ?>Block(const Json::Value &block);
            ~<?php echo $name; ?>Block();

            void initialize(Block *older);
            void tick();

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

            // Implementation headers
            <?php echo $header; ?>
            
        protected:
            void load(const Json::Value &block);
    };
};

#endif
