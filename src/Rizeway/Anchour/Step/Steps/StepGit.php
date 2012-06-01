<?php

namespace Rizeway\Anchour\Step\Steps;

use Rizeway\Anchour\Step\Step;
use Rizeway\Anchour\Connection\ConnectionHolder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StepGit extends StepSsh
{
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setRequired(array(
            'repository',
            'remote_dir',
        ));

        $resolver->setDefaults(array(
            'clean_scm' => true,
            'remove_existing' => false,
            'commands' => array()
        ));
    }

    public function run(OutputInterface $output, ConnectionHolder $connections)
    {
        if (true === $this->options['remove_existing'])
        {
            $this->options['commands'][] = sprintf('rm -rf %s', $this->options['remote_dir']);
        }

        $this->options['commands'][] = sprintf('git clone %s %s', $this->options['repository'], $this->options['remote_dir']);

        if (true === $this->options['clean_scm'])
        {
            $this->options['commands'][] = sprintf('rm -rf %s/.git', $this->options['remote_dir']);
        }

        parent::run($output, $connections);
    }
}