<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Events\ExampleMail;
use Illuminate\Console\Command;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:sendexample';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an example email';

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
    public function handle()
    {
        event(new ExampleMail());    
    }
}