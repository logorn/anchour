<?php

namespace Rizeway\Anchour\Step\Steps;

use Rizeway\Anchour\Step\Step;
use Rizeway\Anchour\Connection\ConnectionHolder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Console\Output\OutputInterface;
use OOSSH\SSH2\Connection;
use OOSSH\SSH2\Authentication\Password;

class StepSsh extends Step
{
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'connection',
            'commands'
        ));
    }

    public function run(OutputInterface $output, ConnectionHolder $connections)
    {
        $connection = $connections[$this->options['connection']];
        $connection->connect($output);

        foreach ($this->options['commands'] as $command)
        {
            $connection->exec($command, function($stdio, $stderr) use($output) {
              $output->write($stdio);

              if('' !== $stderr)
              {
                throw new \RuntimeException($stderr);
              }
            });
        }
    }
}