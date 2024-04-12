<?php 

namespace App\Command;

use App\Entity\User;
use App\Enum\UserRoleEnum;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:create:user')]
class CreateUserCommand extends Command {

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Create a new user with specified roles.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $helper = $this->getHelper('question');

        $userNameQuestion = new Question('Please enter the username of the user:');
        $username = $helper->ask($input, $output, $userNameQuestion);

        $emailQuestion = new Question('Please enter the email of the user:');
        $email = $helper->ask($input, $output, $emailQuestion);

        $rolesQuestion = new ChoiceQuestion('Please select user roles', UserRoleEnum::toArray(), 0);
        $rolesQuestion->setMultiselect(true);
        $roles = $helper->ask($input, $output, $rolesQuestion);

        $passwordQuestion = new Question('Please specify the password:');
        $passwordQuestion->setHidden(true)->setHiddenFallback(true);
        $password = $helper->ask($input,$output, $passwordQuestion);

        $user = new User();

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setRoles($roles);
        $user->setPlainPassword($password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success('User created succesfully!');

        return 0;            
    }
}