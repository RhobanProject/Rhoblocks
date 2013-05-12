cmake_minimum_required (VERSION 2.6)
project (RhoblocksServer)

set (MONGOOSE_CPP_DIR "${PROJECT_SOURCE_DIR}/mongoose-cpp/"
    CACHE STRING "Mongoose-cpp directory")

set (BLOCKS_INTERPRETER_DIR "${PROJECT_SOURCE_DIR}/blocks/"
    CACHE STRING "Blocks Interpreter directory")

# Web static files
add_custom_command(
    OUTPUT "${PROJECT_BINARY_DIR}/www"
    COMMAND cp -R "${PROJECT_SOURCE_DIR}/www" "${PROJECT_BINARY_DIR}/"
    DEPENDS "${PROJECT_SOURCE_DIR}/www"
    )
add_custom_command(
    OUTPUT "${PROJECT_BINARY_DIR}/www/blocks.json"
    COMMAND cp -R "${BLOCKS_INTERPRETER_DIR}/blocks.json" "${PROJECT_BINARY_DIR}/www/blocks.json"
    DEPENDS "${BLOCKS_INTERPRETER_DIR}/blocks.json"
    )
add_custom_target (wwwFile ALL DEPENDS "${PROJECT_BINARY_DIR}/www" "${PROJECT_BINARY_DIR}/www/blocks.json")

# Adding mongoose & blocks interpreter
add_subdirectory("${MONGOOSE_CPP_DIR}")
add_subdirectory("${BLOCKS_INTERPRETER_DIR}")

# Adding includes
include_directories ("${MONGOOSE_CPP_DIR}")
include_directories ("${BLOCKS_INTERPRETER_DIR}")

# Setting sources
set (ALL_SOURCES
    )
set (DIRECTORIES
    "${PROJECT_SOURCE_DIR}/src/"
    )

foreach (DIRECTORY ${DIRECTORIES})
    message ("-- Adding ${DIRECTORY}")
    include ("${DIRECTORY}/Sources.cmake")

    foreach (SOURCE ${SOURCES})
        set (ALL_SOURCES ${ALL_SOURCES} "${DIRECTORY}/${SOURCE}")
    endforeach (SOURCE)
endforeach (DIRECTORY)

# Adding the Server executable, linked with mongoose and the 
# blocks interpreter
add_executable (Server ${ALL_SOURCES})
target_link_libraries (Server _mongoose BlocksInterpreter)
