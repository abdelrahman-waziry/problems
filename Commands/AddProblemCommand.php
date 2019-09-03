<?php
// src/Command/CreateUserCommand.php
namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddProblemCommand extends Command
{
    const PROBLEMS_DIR = __DIR__ . '/../' .'problems';
    const SOLUTIONS_DIR = __DIR__ . '/../' . 'solutions';
    const BASE_DIR = __DIR__ . '/..' ;

    protected static $defaultName = 'add:problem';

    protected function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'Problem Name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = ucfirst($input->getArgument('name'));
        $problem_file = $this->createProblemFile($input, $output);
        $solution_file = $this->createSolutionFile($input, $output);
        if ($problem_file && $solution_file) {
            $this->addLinks($name);
        }
    }

    private function createProblemFile($input, $output) : bool
    {
        $name = $input->getArgument('name');
        $file_name = str_slug($name) . '.md';
        $path = self::PROBLEMS_DIR . '/' . $file_name;
        $header = ucfirst($name);
        $content = "# {$header}\n";
        return $this->addFile($path, $content);
    }

    private function createSolutionFile($input, $output) : bool
    {
        $name = $input->getArgument('name');
        $file_name = str_slug($name) . '.php';
        $path = self::SOLUTIONS_DIR. '/' . $file_name;
        $content = "<?php\n";
        return $this->addFile($path, $content);
    }

    private function addLinks($name) : void
    {
        $slug = str_slug($name);
        $problem = "{$slug}.md";
        $solution = "{$slug}.php";
        $path = self::BASE_DIR . '/README.md';
        $lines = count(file($path));
        $number = $lines - 6;
        $file = fopen($path, 'a');
        $contents = "|{$number}| {$name} | [{$problem}](/problems/{$problem}) | [{$solution}](/solutions/{$solution})|\n";
        fwrite($file, $contents);
        fclose($file);
    }

    private function addFile($path, $content) : bool
    {
        if (file_exists($path)) {
            return false;
        }
        $file = fopen($path, 'w');
        fwrite($file, $content);
        fclose($file);
        return true;
    }
}
