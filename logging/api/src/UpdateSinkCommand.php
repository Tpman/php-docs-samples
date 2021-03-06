<?php
/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Samples\Logging;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UpdateSinkCommand
 * @package Google\Cloud\Samples\Logging
 *
 * This command simply updates a sink.
 */
class UpdateSinkCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('update-sink')
            ->setDescription('Updates a Logging sink')
            ->addOption(
                'sink',
                null,
                InputOption::VALUE_OPTIONAL,
                'The name of the Logging sink',
                'my_sink'
            )->addOption(
                'filter',
                null,
                InputOption::VALUE_OPTIONAL,
                'The filter expression for the sink',
                ''
            );
        $this->addCommonOptions();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sinkName = $input->getOption('sink');
        $projectId = $input->getOption('project');
        $loggerName = $input->getOption('logger');
        $filter = $input->getOption('filter');
        $loggerFullName = sprintf(
            'projects/%s/logs/%s',
            $projectId,
            $loggerName
        );
        $filterString = sprintf('logName = "%s"', $loggerFullName);
        if (!empty($filter)) {
            $filterString .= ' AND ' . $filter;
        }
        update_sink($projectId, $sinkName, $filterString);
        printf("Updated a sink '%s'." . PHP_EOL, $sinkName);
    }
}
