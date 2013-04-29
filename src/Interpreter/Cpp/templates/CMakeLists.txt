cmake_minimum_required (VERSION 2.6)
project (BlocksInterpreter)

set (SOURCES
    blocks/Block.cpp
    blocks/Scene.cpp
    blocks/Loader.cpp
    blocks/Edge.cpp
    blocks/Index.cpp
    blocks/Scheduler.cpp
    <?php foreach ($blocks as $block) { ?>
    blocks/<?php echo $block['name']; ?>Block.cpp
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
