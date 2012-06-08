<?php
namespace Rizeway\Anchour\Step\Steps;

use Symfony\Component\Console\Output\OutputInterface;

use Rizeway\Anchour\Step\Step;
use Rizeway\Anchour\Step\Definition\Definition;

class StepEcho extends Step
{
    protected function setDefaultOptions()
    {
        $this->addOption('message', Definition::TYPE_REQUIRED);
    }

    public function run(OutputInterface $output)
    {
        $output->writeln($this->getOption('message'));
    }
}