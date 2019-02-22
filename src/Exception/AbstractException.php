<?php

namespace App\Exception;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class AbstractException extends \Exception
{
    protected $data;
    /** @var ConstraintViolationListInterface $constraintViolations */
    protected $constraintViolations;

    public function __construct(string $message = '', array $data = [], $code = 0)
    {
        parent::__construct($message, $code);

        $this->data = $data;
        if (isset($this->data['violations'])
            && $this->data['violations'] instanceof ConstraintViolationListInterface
        ) {
            $this->constraintViolations = $this->data['violations'];
        } else {
            $this->constraintViolations = null;
        }
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getConstraintViolations(): ?ConstraintViolationListInterface
    {
        return $this->constraintViolations;
    }

    public function outputViolations(OutputInterface $output): void
    {
        if ($this->constraintViolations !== null) {
            /** @var ConstraintViolation $error */
            foreach ($this->constraintViolations as $error) {
                $output->writeln($error->getPropertyPath().' | '.$error->getMessage());
            }
        }
    }

    public function outputMessage(OutputInterface $output): void
    {
        $output->writeln($this->getMessage().'\n'.(string)$this->getData());
    }
}
