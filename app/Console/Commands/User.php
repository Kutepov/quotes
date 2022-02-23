<?php

namespace App\Console\Commands;

use App\Services\UserService;
use Illuminate\Console\Command;
use Illuminate\Validation\ValidationException;

class User extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(UserService $userService)
    {
        try {
            $data = ['email' => $this->argument('email'), 'password' => $this->argument('password')];
            $userService->create($data);
            $this->table(['Email', 'Password'], [$data]);
        } catch (ValidationException $exception) {
            foreach ($exception->errors() as $field) {
                foreach ($field as $error) {
                    $this->error($error);
                }
            }
        }
        return 0;
    }
}
