cmake_minimum_required (VERSION 2.6)
project (BlocksInterpreter)

set (SOURCES
    blocks/Loader.cpp
    <?php foreach ($files as $file) { ?>
    blocks/<?php echo $file; ?>.cpp
    <?php } ?>
    <?php foreach ($blocks as $block) { ?>
    blocks/<?php echo $block->getFileName(); ?>.cpp
    <?php } ?>
    )

set (MAIN
    main.cpp
    )

include_directories ("${BlocksInterpreter_SOURCE_DIR}")

add_library (BlocksInterpreter ${SOURCES})
target_link_libraries (BlocksInterpreter jsoncpp matheval)

add_executable (Interpreter ${MAIN})
target_link_libraries (Interpreter BlocksInterpreter)
