#include <stdio.h>
#include <matheval.h>

void ExpressionBlock::initialize(Block *old)
{
    int size = x.size();
    evaluator = evaluator_create((char *)expression.c_str());
    names = new char*[size];
    for (int i=0; i<size; i++) {
        ostringstream oss;
        oss << "X" << (i+1);
        names[i] = new char[10];
        sprintf(names[i], "%s", oss.str().c_str());
    }
}

void ExpressionBlock::tick()
{
    int size = x.size();
    double values[size];

    for (int i=0; i<size; i++) {
        values[i] = x[i];
    }

    result = evaluator_evaluate(evaluator, size, names, values);
}

void ExpressionBlock::destroy()
{
    for (int i=0; i<x.size(); i++) {
        delete[] names[i];
    }

    delete[] names;
}
