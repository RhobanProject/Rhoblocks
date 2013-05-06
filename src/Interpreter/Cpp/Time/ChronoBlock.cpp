namespace Blocks
{
    void ChronoBlock::initialize(Block *old)
    {
        T = defaultValue-scene->getPeriod();
    }

    void ChronoBlock::tick()
    {
        if (reset) {
            T = 0;
        } else {
            if (!pause) {
                T += factor*scene->getPeriod();
            }
        }
    }
};
