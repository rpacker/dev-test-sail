<?php

namespace App\Console\Commands;

use App\Models\EmailData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ProcessEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:process';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process emails';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    
    /**
     * regexp for email (more safe than robust)
     * 
     * @var string 
     */
    protected $emailPattern = '[a-zA-z0-9.-]+\@[a-zA-z0-9.-]+.[a-zA-Z]+';
    
    
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        echo "Start processing emails...\n";
        
        try {
            // file path
            $emailFilesPath = storage_path('emails/');
    
            // iterate the files
            foreach (File::allFiles($emailFilesPath) as $file) {
                printf("\n----------------------File: %s-----------------------------\n", $file->getFilename());
                $data = [];
        
                $contents = file_get_contents($emailFilesPath . $file->getFilename());
        
                // parse emails
                // get To
                $data['to'] = $this->getTo($contents);
        
                // get From
                $data['from'] = $this->getFrom($contents);
        
                // get Date
                $data['email_date'] = $this->getDate($contents);
        
                // get Subject
                $data['subject'] = $this->getSubject($contents);
        
                // get Message-ID
                $data['message_id'] = $this->getMessageId($contents);
        
                // print it to stdout
                print_r($data);
        
                // log it to storage/log/laravel.log
                Log::debug('Email data', $data);
        
                // do db insert
                $emailData = EmailData::create($data);
                //echo '$emailData: '; print_r($emailData); echo "\n";
                
            }
    
            echo "Done.\n\n";
            
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        
        
        
        return Command::SUCCESS;
    }
    
    /**
     * @param string $contents
     * @return string
     */
    protected function getMessageId(string $contents): string
    {
        preg_match("/Message-ID:[\s]?([<].+?[>])\n/", $contents, $matches);

        return $matches[1] ?? '';
    }
    
    /**
     * @param string $contents
     * @return string
     */
    protected function getSubject(string $contents): string
    {
        preg_match("/[^:]Subject[: ]*(.*)\n/", $contents, $matches);
        
        return $matches[1] ?? '';
    }
    
    /**
     * @param string $contents
     * @return string
     */
    protected function getDate(string $contents): string
    {
        preg_match("/Date:\s([A-Za-z0-9,:+() -]+)\n/", $contents, $matches);

        return $matches[1] ?? '';
    }
    
    protected function getTo(string $contents): string
    {
        preg_match("/[^-]To:\s(.+?$this->emailPattern>?)/", $contents, $matches);
        
        return $matches[1] ?? '';
    }
    
    /**
     * @param string $contents
     * @return string
     */
    protected function getFrom(string $contents): string
    {
        preg_match('/From:\s(.+?<?' . $this->emailPattern . '>?)/', $contents, $matches);

        return $matches[1] ?? '';
    }
}
