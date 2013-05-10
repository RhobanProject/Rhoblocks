
namespace Blocks
{
    class ExpressionBlock : public ExpressionBlockBase
    {
        public:
            void destroy();
            void initialize(Block *);
            void tick();

        protected:
            void *evaluator;
            char **names;
    };
};
