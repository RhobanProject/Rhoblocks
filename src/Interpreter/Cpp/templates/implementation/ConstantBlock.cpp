void ConstantBlock::initialize(Block *old)
{
    for (int i=0; i<value.size(); i++) {
        value[i] = values_value[i];
    }
}

void ConstantBlock::tick()
{
}
