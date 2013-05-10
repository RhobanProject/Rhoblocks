
namespace Blocks
{
    class PulseBlock : public PulseBlockBase
    {
        public:
            void initialize(Block *old);
            void tick();

        protected:
            int counter;
    };
};
