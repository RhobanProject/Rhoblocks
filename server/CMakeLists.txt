cmake_minimum_required (VERSION 2.6)
project (RhoblocksServer)

set (MONGOOSE_CPP_DIR "${PROJECT_SOURCE_DIR}/mongoose-cpp/"
    CACHE STRING "Mongoose-cpp directory")

set (BLOCKS_INTERPRETER_DIR "${PROJECT_SOURCE_DIR}/blocks/"
    CACHE STRING "Blocks Interpreter directory")

# Adding mongoose & blocks interpreter
add_subdirectory("${MONGOOSE_CPP_DIR}")
add_subdirectory("${BLOCKS_INTERPRETER_DIR}")

# Adding includes
include_directories ("${MONGOOSE_CPP_DIR}")
include_directories ("${BLOCKS_INTERPRETER_DIR}")

# Setting sources
set (SOURCES
    src/main.cpp
    )

# Adding the Server executable, linked with mongoose and the 
# blocks interpreter
add_executable (Server ${SOURCES})
target_link_libraries (Server _mongoose BlocksInterpreter)
