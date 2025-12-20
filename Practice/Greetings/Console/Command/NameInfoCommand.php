<?php

declare(strict_types=1);

namespace \Greetings\Console\Command;

use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Console command to output a provided name and dispatch a custom event.
 */
class NameInfoCommand extends Command
{
    private const NAME = 'name';
    private const EVENT_NAME = '_greetings_command_event';
    private const COMMAND_NAME = ':greetings:nameinfo';

    /**
     * Constructor
     *
     * @param ManagerInterface $eventManager
     */
    public function __construct(protected readonly ManagerInterface $eventManager)
    {
        parent::__construct(self::COMMAND_NAME);
    }

    /**
     * Command Configuration method
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->setDescription('This is my first console command.');
        $this->addOption(
            name: self::NAME,
            mode:InputOption::VALUE_REQUIRED,
            description: 'Name'
        );
    }

    /**
     * Executes the command: outputs provided name and dispatches event.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $exitCode = 0;

        if ($name = $input->getOption(self::NAME)) {
            $output->writeln(sprintf('<info>Provided name is `%s`</info>', $name));
            $this->eventManager->dispatch(self::EVENT_NAME, [
                'name' => $name
            ]);
        }

        $output->writeln('<info>Success message.</info>');
        $output->writeln('<comment>Some comment.</comment>');

        try {
            if (rand(0, 1)) {
                throw new LocalizedException(__('An error occurred.'));
            }
        } catch (LocalizedException $e) {
            $output->writeln(sprintf(
                '<error>%s</error>',
                $e->getMessage()
            ));
            $exitCode = 1;
        }

        return $exitCode;
    }
}
